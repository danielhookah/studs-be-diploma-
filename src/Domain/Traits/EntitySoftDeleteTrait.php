<?php

namespace App\Domain\Traits;

use DateTime;

trait EntitySoftDeleteTrait
{

    /**
     * @ORM\Column(name="`deleted`", type="datetime", nullable=true)
     * @var DateTime|null
     */
    private ?DateTime $deleted = null;

    /**
     * @return DateTime|null
     */
    public function getDeleted(): ?DateTime
    {
        return $this->deleted;
    }

    /**
     * @param DateTime|null $deleted
     */
    public function setDeleted(?DateTime $deleted): void
    {
        $this->deleted = $deleted;
    }
}
