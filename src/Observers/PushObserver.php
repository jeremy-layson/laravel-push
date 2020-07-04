<?php

namespace App\Observers;

use App\Models\AbstractModel as Model;
use App\Models\DataHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\AwsPushTopic;
use JeremyLayson\Push\Libraries\Topic\TopicManager;
use JeremyLayson\Push\Libraries\Subscription\Topic as TopicSubscription;
use JeremyLayson\Push\Libraries\Subscription\Device as DeviceSubscription;

/**
 * @author Jeremy Layson <jeremy.b.layon@gmail.com>
 * @version 1.0
 * @since 04.07.2020
 */
class PushObserver
{
    // checker for topic subscription
    // topic name from the database => function for checking
    protected $rules = [
        'Active' => 'checkIfActive'
    ];

    public function created(Model $model)
    {
        $this->checkModelForPushUpdate($model);
    }

    public function updated(Model $model)
    {
        $this->checkModelForPushUpdate($model);
    }

    public function deleted(Model $model)
    {
        $this->checkModelForPushUpdate($model);
    }

    /**
     * Usage:
     * Create a separate function for each condition and when it returns true
     * it should subscribe it to the topic if not yet subscribed
     * and vice versa
     */
    public function checkModelForPushUpdate(Model $model)
    {
        // check if the model should be or shouldn't be in a topic
        foreach ($this->rules as $topic => $rule) {
            if ($this->{$rule}($model) === TRUE) {
                $this->subscribeToTopic($topic, $model);
            } else {
                $this->unsubscribeToTopic($topic, $model);
            }
        }

        // check if the model should have a new device
        if (request()->has('aws_push_device_id') === TRUE) {
            $deviceId = request()->aws_push_device_id;   
            $platform = request()->aws_push_device_platform;
            $mode = request()->aws_push_device_mode ?? 'subscribe';
            $platformArn = NULL;

            if ($platform == 'ios') {
                $platformArn = env('AWS_SNS_IOS_ARN');
            }

            if ($platform == 'android') {
                $platformArn = env('AWS_SNS_ANDROID_ARN');
            }

            $subscriber = new DeviceSubscription();

            if ($mode == 'subscribe') {
                $endpointArn = $subscriber->registerDevice($deviceId, ['id' => $model->id], $platformArn);
                // create new device
                $model->awsDevices()->create([
                    'arn'           => $endpointArn,
                    'device_id'     => $deviceId,
                    'platform'      => $platform,
                    'model'         => request()->aws_push_device_model,
                    'os_version'    => request()->aws_push_device_os_version,
                ]);
            } else {
                // find the device
                $device = $model->awsDevice()->where('device_id', $deviceId)->first();
                // unsubscribe
                $subscriber->unsubscribe($device->arn);
                // delete
                $device->delete();
            }
        }
    }

    public function subscribeToTopic($topicName, Model $model)
    {
        // check if topic exists, otherwise create it
        $topic = $this->getTopic($topicName);

        // model must have AwsDevices relationship
        if ($model->AwsDevices === NULL) {
            // abort(403, 'Model does not have an One-To-Many AwsDevices relationship [App\Models\AwsPushDevice]');
        } else {
            // loop through all their devices and subscribe them to the topic
            $subscriber = new TopicSubscription();
            foreach ($model->AwsDevices as $device) {
                $arn = $subscribeToTopic->subscribeToTopic($device->arn, $topic->arn);
                $topic->members()->create([
                    'arn'               => $arn,
                    'name'              => '',
                    'description'       => '',
                    'owner_id'          => $model->id,
                ]);
            }
        }
    }

    public function unsubscribeToTopic($topicName, Model $model)
    {
        $topic = $this->getTopic($topicName);

        // model must have AwsDevices relationship
        if ($model->AwsDevices === NULL) {
            // abort(403, 'Model does not have an One-To-Many AwsDevices relationship [App\Models\AwsPushDevice]');
        } else {
            // loop through all their devices and subscribe them to the topic
            $subscriber = new TopicSubscription();
            foreach ($model->AwsDevices as $device) {
                $subscribeToTopic->unsubscribeToTopic($device->arn, $topic->arn);

            }

            $topic->members()->where('owner_id', $model->id)->delete();
        }
    }

    /**
     * This will return an App\Models\AwsPushTopic model
     */
    public function getTopic($topicName)
    {
        // check if topic exists, otherwise create it
        $topic = AwsPushTopic::where('name', $topicName)->first();

        if (is_null($topic) === TRUE) {
            // create topic
            $topicManager = new TopicManager();
            $topicData = $topicManager->createTopic($topicName);

            $topic = AwsPushTopic::create([
                'arn'           => $topicData['TopicArn'],
                'name'          => $topicName,
                'description'   => '',
            ]);
        }

        return $topic;
    }

    //*********** Put all conditionals here

    public function checkIfActive(Model $model)
    {
        // if ($model->is_active === 1) {
        //     return TRUE;
        // }
        return TRUE;
    }
}
