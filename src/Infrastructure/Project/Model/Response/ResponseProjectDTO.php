<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\Model\Response;

use App\Domain\Project\ProjectEntity;
use App\Infrastructure\Shared\DTO\AbstractDTO;
use App\Infrastructure\User\Model\Response\ResponseUserDTO;

class ResponseProjectDTO extends AbstractDTO
{
    public int $id;
    public string $name;
    public string $description;
    public int $status;
    public string $email;
    public ?string $image;

    /** @var bool|string $creator */
    public $creator = false;

    /**
     * @param ProjectEntity $project
     * @param array $dataToPlug
     */
    public function setData($project, $dataToPlug = [])
    {
        $this->id = $project->getId();
        $this->name = $project->getName();
        $this->description = $project->getDescription();
        $this->status = $project->getStatus();
        $this->email = $project->getEmail();
        $this->image = $project->getImage();

        if (in_array('creator', $dataToPlug)) {
            $creator = new ResponseUserDTO();
            $creator->setData($project->getCreator());
            $this->creator = $creator->toArray();
        }
    }
}