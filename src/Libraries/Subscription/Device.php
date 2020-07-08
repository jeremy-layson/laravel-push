<?php

namespace JeremyLayson\Push\Libraries\Subscription;

use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use JeremyLayson\Push\Libraries\Message\SNSMessage;
use Illuminate\Support\Facades\App;

class Device {

    /**
     * Tested 2020-03-02
     */
    public function registerDevice($token, $payloadModel, $platformArn)
    {
        $client = App::make('aws')->createClient('sns');

        $result = $client->createPlatformEndpoint([
            'CustomUserData' => json_encode($payloadModel),
            'PlatformApplicationArn' => $platformArn,
            'Token' => $token,
        ]);

        return $result['EndpointArn'];
    }

    public function unregisterDevice($arn)
    {
        $client = App::make('aws')->createClient('sns');

        $result = $client->deleteEndpoint([
            'EndpointArn' => $arn
        ]);

        return $result;
    }
}