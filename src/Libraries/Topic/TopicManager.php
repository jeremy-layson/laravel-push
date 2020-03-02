<?php

namespace JeremyLayson\Push\Libraries\Topic;


use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use JeremyLayson\Push\Libraries\Message\SNSMessage;
use Illuminate\Support\Facades\App;

class TopicManager {

    public function createTopic($name, $tags = [])
    {
        $client = App::make('aws')->createClient('sns');

        $result = $client->createTopic([
            'Name' => $name,
            'Tags' => $tags,
        ]);

        return $result;
    }

    public function deleteTopic($topicArn)
    {
        $client = App::make('aws')->createClient('sns');

        $result = $client->deleteTopic([
            'TopicArn' => $topicArn
        ]);

        return $result;
    }

    public function getAllTopics($topicArn, $nextToken = NULL)
    {
        $client = App::make('aws')->createClient('sns');

        $data = ['TopicArn' => $topicArn];

        if (is_null($nextToken) === FALSE) {
            $data['NextToken'] = $nextToken;
        }

        $result = $client->listTopics($data);

        return $result;
    }

    public function getSubscriptions($topicArn, $nextToken = null)
    {
        $client = App::make('aws')->createClient('sns');

        $data = ['TopicArn' => $topicArn];

        if (is_null($nextToken) === FALSE) {
            $data['NextToken'] = $nextToken;
        }

        $result = $client->listSubscriptionsByTopic($data);

        return $result;
    }
}