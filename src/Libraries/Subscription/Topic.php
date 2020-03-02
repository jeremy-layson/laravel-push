<?php

namespace JeremyLayson\Push\Libraries\Subscription;

use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use JeremyLayson\Push\Libraries\Message\SNSMessage;
use Illuminate\Support\Facades\App;

class Topic {

    public function subscribeToTopic($deviceArn, $topicArn)
    {
        $client = App::make('aws')->createClient('sns');

        $result = $client->subscribe([
            'Endpoint' => $deviceArn,
            'Protocol' => 'application',
            'TopicArn' => $topicArn,
            'ReturnSubscriptionArn' => true,
        ]);

        \Log::info($result);

        return $result;
    }

    public function unsubscribeToTopic($subscriptionArn)
    {
        $client = App::make('aws')->createClient('sns');

        $result = $client->unsubscribe([
            'SubscriptionArn' => $subscriptionArn
        ]);

        \Log::info($result);

        return $result;
    }
}