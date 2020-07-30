<?php

declare(strict_types=1);

namespace App\Infrastructure\ProjectUser\Model\Request;

use App\Infrastructure\Shared\DTO\AbstractDTO;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddProjectUserDTO extends AbstractDTO
{
    public int $userId;
    public int $projectId;
    public int $status;

    /**
     * @param array $content
     * @param array $dataToPlug
     */
    public function setData($content, $dataToPlug = [])
    {
        $this->status = (int) !empty($content['status']) ? $content['status'] : 0;
        $this->userId = (int)$content['userId'];
        $this->projectId = (int)$content['projectId'];
    }
}