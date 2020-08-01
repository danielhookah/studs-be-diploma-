<?php

declare(strict_types=1);

namespace App\Infrastructure\Direction\Model\Response;

use App\Domain\Direction\DirectionEntity;
use App\Infrastructure\Shared\DTO\AbstractDTO;

class ResponseDirectionDTO extends AbstractDTO
{
    public int $id;
    public int $status;
    public string $name;
    public string $description;

    /** @var bool|array $lessons */
    public $lessons = false;

    /**
     * @param DirectionEntity $direction
     * @param array $dataToPlug
     */
    public function setData($direction, $dataToPlug = [])
    {
        $this->id = $direction->getId();
        $this->name = $direction->getName();
        $this->description = $direction->getDescription();
        $this->status = $direction->getStatus();
    }
}