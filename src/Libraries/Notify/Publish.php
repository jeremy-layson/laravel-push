<?php

namespace JeremyLayson\Push\Libraries\Notify;

use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use JeremyLayson\Push\Libraries\Message\SNSMessage;
use Illuminate\Support\Facades\App;

class Publish {

    /**
     * Tested 2020-03-02
     */
    public function registerDevice($token, $payloadModel)
    {
        $client = App::make('aws')->createClient('sns');

        $result = $client->createPlatformEndpoint([
            'CustomUserData' => json_encode($payloadModel),
            'PlatformApplicationArn' => env('AWS_SNS_APPLICATION'),
            'Token' => $token,
        ]);

        return $result;
    }
}