<?php

namespace App\Domain\Direction;

use App\Domain\Entities\Entity;
use App\Domain\Project\ProjectEntity;
use App\Domain\Traits\EntityHelperTrait;
use App\Domain\Traits\EntitySoftDeleteTrait;
use App\Infrastructure\Shared\DTO\AbstractDTOInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="`direction`")
 */
class DirectionEntity extends Entity
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
     * @ORM\ManyToOne(targetEntity="App\Domain\Project\ProjectEntity", cascade={"persist"})
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")
     * @var ProjectEntity
     */
    private ProjectEntity $project;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Domain\Subject\SubjectEntity", mappedBy="direction", cascade={"all"})
     */
    private ?Collection $subjects;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="App\Domain\ProjectUser\ProjectUserEntity", mappedBy="directions")
     */
    private ?Collection $projectUsers;

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
        $this->project = $initData['project'];
        $this->image ??= $initData['image'];

        $this->subjects = new ArrayCollection();
        $this->projectUsers = new ArrayCollection();
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
     * @return ProjectEntity
     */
    public function getProject(): ProjectEntity
    {
        return $this->project;
    }

    /**
     * @param ProjectEntity $project
     */
    public function setProject(ProjectEntity $project): void
    {
        $this->project = $project;
    }

    /**
     * @return Collection|null
     */
    public function getSubjects(): ?Collection
    {
        return $this->subjects;
    }

    /**
     * @param Collection|null $subjects
     */
    public function setSubjects(?Collection $subjects): void
    {
        $this->subjects = $subjects;
    }

    /**
     * @return Collection|null
     */
    public function getProjectUsers(): ?Collection
    {
        return $this->projectUsers;
    }

    /**
     * @param Collection|null $projectUsers
     */
    public function setProjectUsers(?Collection $projectUsers): void
    {
        $this->projectUsers = $projectUsers;
    }

}
