<?php
namespace JeremyLayson\Push\Libraries\Message;

use JeremyLayson\Push\Libraries\SNSMessageTemplate;

/**
 * Template for message object for AWS Push Notification
 */
class APNS implements SNSMessageTemplate {

    public function generateMessage($data)
    {
        $data = (object) [
            'aps' => 
            (object) [
                'alert' => (object) [
                    'title' => $data['title'],
                    'body' => $data['message']
                ],
                'category' => $data['category'],
                'sound' => $data['sound'] ?? 'default',
                'data' => (object) $data['data'] ?? '[]'
            ]
        ];

        return json_encode($data);
    }

    public function isValidMessage($data)
    {
        $isValid = TRUE;

        if (isset($data['message']) === FALSE) $isValid = false;
        if (isset($data['category']) === FALSE) $isValid = false;
        if (isset($data['title']) === FALSE) $isValid = false;

        return $isValid;
    }
}