<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Exception;

use Throwable;

class SendEmailException extends \Exception
{
    public function __construct($name = null, $code = 500, Throwable $previous = null)
    {
        parent::__construct($this->getMessageTemplate($name), $code, $previous);
    }

    /**
     * @param $name
     * @return string
     */
    public function getMessageTemplate(?string $name): string
    {
        return $name ? "An error occurred while sending email. $name." : "An error occurred while sending email.";
    }

}
