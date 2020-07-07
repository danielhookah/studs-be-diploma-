<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Exception;

use Throwable;

class CreateEntityException extends \Exception
{
    public function __construct($name = "entity", $code = 500, Throwable $previous = null)
    {
        parent::__construct($this->getMessageTemplate($name), $code, $previous);
    }

    /**
     * @param $name
     * @return string
     */
    public function getMessageTemplate($name): string
    {
        return "An error occurred while add $name.";
    }

}
