<?php
namespace Cms\Models;

class ResponseMessage {

    /**
     * @var bool
     */
    public $success;

    /**
     * @var array
     */
    public $errorMessages;

    /**
     * Message constructor.
     * @param $success
     * @param $errorMessages
     */
    public function __construct($success, $errorMessages) {
        $this->success = $success;
        $this->errorMessages = $errorMessages;
    }
}