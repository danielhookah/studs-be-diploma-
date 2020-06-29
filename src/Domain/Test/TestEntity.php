<?php

namespace App\Domain\Test;

use App\Domain\Entities\Entity;
use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="`test`")
 */
class TestEntity extends Entity
{

    /**
     * @ORM\Column(name="`status`", type="integer", nullable=true)
     * @var integer|null
     */
    private $status;

    /**
     * @var string|null
     * @ORM\Column(name="`name`", type="string", nullable=true)
     */
    private $name;

    /**
     * Entity constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->setCreated(new DateTime());
        $this->setUpdated(new DateTime());
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

}
