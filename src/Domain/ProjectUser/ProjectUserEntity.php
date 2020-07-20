<?php

namespace App\Domain\ProjectUser;

use App\Domain\Entities\Entity;
use App\Domain\Project\ProjectEntity;
use App\Domain\Traits\EntityHelperTrait;
use App\Domain\User\UserEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="`project_user`")
 */
class ProjectUserEntity extends Entity
{
    use EntityHelperTrait;

    /**
     * @ORM\Column(name="`status`", type="integer", nullable=true)
     * @var integer
     */
    private int $status;

    // Joins

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Project\ProjectEntity", cascade={"persist"})
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")
     * @var ProjectEntity
     */
    private ProjectEntity $project;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\User\UserEntity", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @var UserEntity
     */
    private UserEntity $user;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="App\Domain\Direction\DirectionEntity", inversedBy="users")
     * @ORM\JoinTable(name="project_user_direction",
     *  joinColumns={@ORM\JoinColumn(name="project_user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="direction_id", referencedColumnName="id")}
     *      )
     */
    private ?Collection $directions;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="App\Domain\Group\GroupEntity", mappedBy="projectUsers")
     */
    private ?Collection $groups;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\ProjectUserDate\ProjectUserDateEntity", mappedBy="projectUser", cascade={"all"})
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
        $this->project = $initData['project'];
        $this->user = $initData['user'];

        $this->directions = new ArrayCollection();
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
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @param UserEntity $user
     */
    public function setUser(UserEntity $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Collection|null
     */
    public function getDirections(): ?Collection
    {
        return $this->directions;
    }

    /**
     * @param Collection|null $directions
     */
    public function setDirections(?Collection $directions): void
    {
        $this->directions = $directions;
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
