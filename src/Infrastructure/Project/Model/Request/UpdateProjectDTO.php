<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\Model\Request;

use App\Infrastructure\Shared\DTO\AbstractDTO;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateProjectDTO extends AbstractDTO
{
    public string $name;
    public string $description;
    public string $email;
    public int $status;
    public ?string $image;

    /**
     * @param array $content
     */
    public function setData($content)
    {
        $this->status = (int) !empty($content['status']) ? $content['status'] : 0;
        $this->name = $content['name'];
        $this->description = $content['description'];
        $this->email = $content['email'];
        $this->image ??= $content['image'];
    }
}