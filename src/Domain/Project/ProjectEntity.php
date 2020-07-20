<?php

namespace App\Domain\Project;

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
 * @ORM\Table(name="`project`")
 */
class ProjectEntity extends Entity
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
     * @var string
     * @ORM\Column(name="`email`", type="string", nullable=true)
     */
    private string $email;

    /**
     * @var string|null
     * @ORM\Column(name="`image_path`", type="string", length=255, nullable=true)
     */
    private ?string $image;

    // Joins

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Domain\ProjectUser\ProjectUserEntity", mappedBy="project", cascade={"all"})
     */
    private ?Collection $projectUsers;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="App\Domain\Direction\DirectionEntity", mappedBy="project", cascade={"all"})
     */
    private ?Collection $directions;

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
        $this->email = $initData['email'];
        $this->image ??= $initData['image'];

        $this->projectUsers = new ArrayCollection();
        $this->directions = new ArrayCollection();
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
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

}
