<?php

declare(strict_types=1);

namespace App\Infrastructure\Direction\Model\Request;

use App\Infrastructure\Shared\DTO\AbstractDTO;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateDirectionDTO extends AbstractDTO
{
    public string $name;
    public string $description;
    public int $status;

    /**
     * @param array $content
     * @param array $dataToPlug
     */
    public function setData($content, $dataToPlug = [])
    {
        $this->status = (int) !empty($content['status']) ? $content['status'] : 0;
        $this->name = $content['name'];
        $this->description = $content['description'];
    }
}