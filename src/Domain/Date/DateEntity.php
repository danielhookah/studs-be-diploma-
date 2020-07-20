<?php

namespace App\Domain\Date;

use App\Domain\Direction\DirectionEntity;
use App\Domain\Entities\Entity;
use App\Domain\ProjectUser\ProjectUserEntity;
use App\Domain\ProjectUserDate\ProjectUserDateEntity;
use App\Domain\Subject\SubjectEntity;
use App\Domain\Traits\EntityHelperTrait;
use App\Domain\Traits\EntitySoftDeleteTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="`date`")
 */
class DateEntity extends Entity
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
     * @ORM\ManyToOne(targetEntity="App\Domain\Subject\SubjectEntity", cascade={"persist"})
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", onDelete="CASCADE")
     * @var SubjectEntity
     */
    private SubjectEntity $subject;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="App\Domain\Group\GroupEntity", mappedBy="dates")
     */
    private ?Collection $groups;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\ProjectUserDate\ProjectUserDateEntity", mappedBy="date", cascade={"all"})
     * @var Collection|null
     */
    private ?Collection $projectUserDates;

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
        $this->subject = $initData['subject'];
        $this->image ??= $initData['image'];

        $this->groups = new ArrayCollection();
        $this->projectUserDates = new ArrayCollection();
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
     * @return SubjectEntity
     */
    public function getSubject(): SubjectEntity
    {
        return $this->subject;
    }

    /**
     * @param SubjectEntity $subject
     */
    public function setSubject(SubjectEntity $subject): void
    {
        $this->subject = $subject;
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

    /**
     * @return Collection|null
     */
    public function getProjectUserDates(): ?Collection
    {
        return $this->projectUserDates;
    }

    /**
     * @param Collection|null $projectUserDates
     */
    public function setProjectUserDates(?Collection $projectUserDates): void
    {
        $this->projectUserDates = $projectUserDates;
    }

}
