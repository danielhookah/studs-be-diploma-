<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Model\Response;

class ResponseUserDTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    public function __construct(int $id, string $name, array $ingredients, ?string $image)
    {
        $this->id = $id;
        $this->firstName = $name;
        $this->lastName = $ingredients;
        $this->phone = $image;
        $this->email = $image;
    }
}