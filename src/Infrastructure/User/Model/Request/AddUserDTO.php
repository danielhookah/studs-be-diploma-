<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Model\Request;

use App\Infrastructure\Shared\DTO\AbstractDTO;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddUserDTO extends AbstractDTO
{
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $email;
    public int $status;

    /**
     * @param array $content
     */
    public function setData($content)
    {
        $this->firstName = $content['firstName'];
        $this->lastName = $content['lastName'];
        $this->phone = $content['phone'];
        $this->email = $content['email'];
        $this->status = (int) !empty($content['status']) ? $content['status'] : 0;
    }
}