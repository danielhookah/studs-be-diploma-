<?php

namespace App\Infrastructure\Shared\Traits;

trait ResponseHelperTrait {

    protected function buildResponseMessage($message) : array
    {
        return ['message' => $message];
    }

}
