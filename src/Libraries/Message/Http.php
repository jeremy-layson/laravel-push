<?php
namespace JeremyLayson\Push\Libraries\Message;

use JeremyLayson\Push\Libraries\Message\SNSMessageTemplate;

/**
 * Template for message object for AWS Push Notification
 */
class Http implements SNSMessageTemplate {

    public function generateMessage($data)
    {
        return json_encode($data['message']);
    }

    public function isValidMessage($data)
    {
        return isset($data['message']);
    }
}