<?php

namespace JeremyLayson\Push\Libraries\Message;

/**
 * Template for message object for AWS Push Notification
 */
interface SNSMessageTemplate {
    public function generateMessage($data);
    public function isValidMessage($data);
}