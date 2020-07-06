<?php

namespace JeremyLayson\Push\Libraries\Message;

use JeremyLayson\Push\Libraries\Message\APNS;
use JeremyLayson\Push\Libraries\Message\APNS_SANDBOX;
use JeremyLayson\Push\Libraries\Message\Default;
use JeremyLayson\Push\Libraries\Message\GCM;
use JeremyLayson\Push\Libraries\Message\Http;
use JeremyLayson\Push\Libraries\Message\Https;

/**
 * Message object for AWS Push Notification
 */
class SNSMessage {

    public $valid = TRUE;

    protected $data;

    protected $payloadList = [
        'APNS' => new APNS(),
        'APNS_SANDBOX' => new APNS_SANDBOX(),
        'default' => new Default(),
        'GCM' => new GCM(),
        // 'http' => new Http(),
        // 'https' => new Https(),
    ];

    public function __construct(Array $data, $abortIfInvalid = FALSE)
    {
        $this->data = $data;
        $this->verifyData($abortIfInvalid);

        return $this;
    }

    /**
     * Compare the payload to the requirements
     * of all payload format
     */
    protected function verifyData($onInvalidAbort = FALSE)
    {
        foreach ($payloadList as $key => $payload) {
            $result = $payload->isValidMessage($this->data);

            if ($result === FALSE ) {
                $this->valid = FALSE;
                if ($onInvalidAbort === TRUE) {
                    abort('Invalid or missing data format for SNS Payload');
                }
            }
        }

        return $this;
    }

    public function generatePayload()
    {
        $data = [];

        foreach ($payloadList as $key => $payload) {
            $data[$key] = $payload->generateMessage($this->data);
        }

        return json_encode($data);
    }
}