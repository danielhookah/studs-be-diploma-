<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Model\Response;

use App\Domain\User\UserEntity;
use App\Infrastructure\Shared\DTO\AbstractDTO;
use Psr\Http\Message\ServerRequestInterface as Request;

class ResponseUserDTO extends AbstractDTO
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $email;
    public int $status;
    public string $image;

    /**
     * @param UserEntity $user
     */
    public function setData($user)
    {
        $this->id = $user->getId();
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
        $this->phone = $user->getPhone();
        $this->email = $user->getEmail();
        $this->status = $user->getStatus();
//        $this->image = $user->getImage();
    }
}