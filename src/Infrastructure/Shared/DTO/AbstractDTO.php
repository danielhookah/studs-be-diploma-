<?php
declare(strict_types=1);

namespace App\Infrastructure\Shared\DTO;

use App\Infrastructure\Shared\DTO\AbstractDTOInterface;
use phpDocumentor\Reflection\Types\Mixed_;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

abstract class AbstractDTO implements AbstractDTOInterface
{

    public abstract function setData($data, $dataToPlug = []);

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this as $key => $value) {
            if ($value === false) continue;
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
