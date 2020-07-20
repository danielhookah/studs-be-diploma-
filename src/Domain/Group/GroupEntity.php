<?php

namespace App\Domain\Group;

use App\Domain\Entities\Entity;
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
 * @ORM\Table(name="`group`")
 */
class GroupEntity extends Entity
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
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="App\Domain\ProjectUser\ProjectUserEntity", inversedBy="groups")
     * @ORM\JoinTable(name="group_project_user",
     *  joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="project_user_id", referencedColumnName="id")}
     *      )
     */
    private ?Collection $projectUsers;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="App\Domain\Date\DateEntity", inversedBy="groups")
     * @ORM\JoinTable(name="group_date",
     *  joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="date_id", referencedColumnName="id")}
     *      )
     */
    private ?Collection $dates;

    /**
     * @var Collection|null
     * @ORM\ManyToMany(targetEntity="App\Domain\Subject\SubjectEntity", inversedBy="groups")
     * @ORM\JoinTable(name="group_subject",
     *  joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="subject_id", referencedColumnName="id")}
     *      )
     */
    private ?Collection $subjects;

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

        $this->projectUsers = new ArrayCollection();
        $this->dates = new ArrayCollection();
        $this->subjects = new ArrayCollection();
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

}
