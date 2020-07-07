<?php
namespace JeremyLayson\Push\Libraries\Message;

use JeremyLayson\Push\Libraries\Message\SNSMessageTemplate;

/**
 * Template for message object for AWS Push Notification
 */
class GCM implements SNSMessageTemplate {

    public function generateMessage($data)
    {
        $data = (object) [
            'notification' => (object) [
                'body' => $data['message'],
                'title' => $data['title'],
                'sound' => $data['sound'] ?? 'default',
            ],
            'category' => $data['category'],
            'data' => (object) $data['data'] ?? '[]',
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