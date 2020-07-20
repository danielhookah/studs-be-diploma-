<?php

namespace App\Domain\Subject;

use App\Domain\Direction\DirectionEntity;
use App\Domain\Entities\Entity;
use App\Domain\Traits\EntityHelperTrait;
use App\Domain\Traits\EntitySoftDeleteTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="`subject`")
 */
class SubjectEntity extends Entity
{
    use EntityHelperTrait;
    use EntitySoftDeleteTrait;

    /**
     * @ORM\Column(name="`status`", type="integer", nullable=true)
     * @var integer
     */
    private int $status;

    /**
     * @var string
     * @ORM\Column(name="`name`", type="string", nullable=true)
     */
    private string $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private string $description;

    /**
     * @var string|null
     * @ORM\Column(name="`image_path`", type="string", length=255, nullable=true)
     */
    private ?string $image;

    // Joins

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Direction\DirectionEntity", cascade={"persist"})
     * @ORM\JoinColumn(name="direction_id", referencedColumnName="id", onDelete="CASCADE")
     * @var DirectionEntity
     */
    private DirectionEntity $direction;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Domain\Date\DateEntity", mappedBy="subject", cascade={"all"})
     */
    private ?Collection $dates;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="App\Domain\Group\GroupEntity", mappedBy="subjects")
     */
    private ?Collection $groups;

    /**
     * Entity constructor.
     * @param array $initData
     * @throws Exception
     */
    public function __construct(array $initData = [])
    {
        parent::__construct();

        $this->status = $initData['status'];
        $this->name = $initData['name'];
        $this->description = $initData['description'];
        $this->direction = $initData['direction'];
        $this->image ??= $initData['image'];

        $this->dates = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return DirectionEntity
     */
    public function getDirection(): DirectionEntity
    {
        return $this->direction;
    }

    /**
     * @param DirectionEntity $direction
     */
    public function setDirection(DirectionEntity $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return Collection|null
     */
    public function getDates(): ?Collection
    {
        return $this->dates;
    }

    /**
     * @param Collection|null $dates
     */
    public function setDates(?Collection $dates): void
    {
        $this->dates = $dates;
    }

    /**
     * @return Collection|null
     */
    public function getGroups(): ?Collection
    {
        return $this->groups;
    }

    /**
     * @param Collection|null $groups
     */
    public function setGroups(?Collection $groups): void
    {
        $this->groups = $groups;
    }

}
