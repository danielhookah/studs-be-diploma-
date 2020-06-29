<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Model\Request;

use App\Infrastructure\Shared\DTO\AbstractDTO;

class UpdateUserDTO extends AbstractDTO
{
    public string $firstName;
    public string $lastName;
    public string $phone;

    /**
     * @param array $content
     */
    public function setData($content)
    {
        $this->firstName = $content['firstName'];
        $this->lastName = $content['lastName'];
        $this->phone = $content['phone'];
    }
}