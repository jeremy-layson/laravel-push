<?php

namespace JeremyLayson\Push\Libraries\Notify;

use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use JeremyLayson\Push\Libraries\Message\SNSMessage;
use Illuminate\Support\Facades\App;

class Publish {

    public function publishToTopic($topicArn)
    {
        return $this->publish($topicArn);
    }

    public function publishToArn($arn)
    {
        return $this->publish($arn, 'arn');
    }

    public function publish($arn, $mode = 'topic')
    {
        $client = App::make('aws')->createClient('sns');

        $payload = [
            'Message' => 'Hello World', // REQUIRED
            'MessageAttributes' => [
                'id' => [
                    'DataType' => 'Number', // REQUIRED
                    'StringValue' => '1',
                ],
                'name' => [
                    'DataType' => 'String', // REQUIRED
                    'StringValue' => 'Jeremy Layson',
                ],
            ],
            'MessageStructure' => 'json',
            'TopicArn' => '<string>',
        ];

        if ($mode === 'topic') {
            $payload['TopicArn'] = $arn;
        } else {
            $payload['TargetArn'] = $arn;
        }

        $client->publish($payload);

        return $result;
    }
}