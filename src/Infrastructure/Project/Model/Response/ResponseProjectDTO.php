<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\Model\Response;

use App\Domain\Project\ProjectEntity;
use App\Infrastructure\Shared\DTO\AbstractDTO;
use Psr\Http\Message\ServerRequestInterface as Request;

class ResponseProjectDTO extends AbstractDTO
{
    public int $id;
    public string $name;
    public string $description;
    public int $status;
    public string $email;
    public ?string $image;

    /**
     * @param ProjectEntity $project
     */
    public function setData($project)
    {
        $this->id = $project->getId();
        $this->name = $project->getName();
        $this->description = $project->getDescription();
        $this->status = $project->getStatus();
        $this->email = $project->getEmail();
        $this->image = $project->getImage();
    }
}