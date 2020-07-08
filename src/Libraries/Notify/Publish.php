<?php

namespace JeremyLayson\Push\Libraries\Notify;

use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use JeremyLayson\Push\Libraries\Message\SNSMessage;
use Illuminate\Support\Facades\App;

class Publish {

    public function publishToTopic($topicArn)
    {
        return $this->publish($topicArn, 'topic', $title, $content);
    }

    public function publishToArn($arn)
    {
        return $this->publish($arn, 'arn', $title, $content);
    }

    public function publish($arn, $mode = 'topic', $title, $content)
    {
        $client = App::make('aws')->createClient('sns');

        $message = [
            'GCM' => json_encode((object) [
                'notification' => (object) [
                    'body'  => $content,
                    'title' => $title,
                    'sound' => 'default'
                ]
            ]),
            'default' => json_encode((object) [
                'notification' => (object) [
                    'body'  => $content,
                    'title' => $title,
                    'sound' => 'default'
                ]
            ]),
        ];

        $payload = [
            'Message' => json_encode($message), // REQUIRED
            // 'MessageAttributes' => [
            //     'id' => [
            //         'DataType' => 'Number', // REQUIRED
            //         'StringValue' => '1',
            //     ],
            //     'name' => [
            //         'DataType' => 'String', // REQUIRED
            //         'StringValue' => 'Jeremy Layson',
            //     ],
            // ],
            'MessageStructure'  => 'json',
            'ttl'               => 360, 
        ];

        if ($mode === 'topic') {
            $payload['TopicArn'] = $arn;
        } else {
            $payload['TargetArn'] = $arn;
        }

        $result = $client->publish($payload);

        return $result;
    }

    public function newPublish($arn, SNSMessage $message, $mode)
    {
        \Log::info([$arn, $mode, $message->generatePayload()]);

        $client = App::make('aws')->createClient('sns');

        $payload = [
            'Message' => $message->generatePayload(),
            'MessageStructure'  => 'json',
            'ttl'               => 360, 
        ];

        if ($mode === 'topic') {
            $payload['TopicArn'] = $arn;
        } else {
            $payload['TargetArn'] = $arn;
        }

        $result = NULL;

        try {
            $result = $client->publish($payload);
        } catch (SnsException $e) {
            \Log::info($e->getMessage());
        }

        return $result;
    }
}