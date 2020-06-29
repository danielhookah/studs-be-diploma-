<?php

namespace App\Domain\Traits;

use App\Infrastructure\Shared\DTO\AbstractDTOInterface;

trait EntityHelperTrait
{

    /**
     * @param AbstractDTOInterface $DTO
     * @param bool $isUpdate
     */
    public function setCommonValues(AbstractDTOInterface $DTO, bool $isUpdate = false)
    {
        foreach ($DTO->toArray() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        // method from Entity (abstract class)
        if ($isUpdate) $this->setUpdatedValue();
    }

}
