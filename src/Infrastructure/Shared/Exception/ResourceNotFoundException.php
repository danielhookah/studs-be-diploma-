<?php
declare(strict_types=1);

namespace App\Infrastructure\Shared\Exception;

use Throwable;

class ResourceNotFoundException extends \Exception
{
    public function __construct($name = "Resource", $code = 500, Throwable $previous = null)
    {
        parent::__construct($this->getMessageTemplate($name), $code, $previous);
    }

    /**
     * @param $name
     * @return string
     */
    public function getMessageTemplate($name): string
    {
        return "$name could not be found.";
    }

}
