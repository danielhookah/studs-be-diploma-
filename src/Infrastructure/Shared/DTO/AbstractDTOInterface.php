<?php
declare(strict_types=1);

namespace App\Infrastructure\Shared\DTO;

use phpDocumentor\Reflection\Types\Mixed_;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Interface AbstractDTOInterface
 * @package App\Infrastructure\Shared
 */
interface AbstractDTOInterface
{
    public function setData($data, array $dataToPlug);

    public function toArray() : array;

    public function toJson() : string;
}
