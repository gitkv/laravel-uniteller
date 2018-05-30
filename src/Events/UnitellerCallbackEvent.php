<?php

namespace gitkv\Uniteller\Events;

class UnitellerCallbackEvent extends Event {

    protected $payload;

    public function __construct(array $payload) {
        $this->payload = $payload;
    }

    public function getPayload() {
        return $this->payload;
    }
}
