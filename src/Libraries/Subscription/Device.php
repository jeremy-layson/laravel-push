<?php

namespace JeremyLayson\Push\Libraries\Subscription;

use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use JeremyLayson\Push\Libraries\Message\SNSMessage;

class Device {

    public function registerDevice($token, $payloadModel)
    {
        $client = new SnsClient();

        $result = $client->createPlatformEndpoint([
            'CustomUserData' => json_encode($payloadModel),
            'PlatformApplicationArn' => env('AWS_SNS_APPLICATION'),
            'Token' => $deviceToken,
        ]);

        return $result;
    }
}