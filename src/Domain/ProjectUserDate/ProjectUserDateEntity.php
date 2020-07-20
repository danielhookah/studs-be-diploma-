<?php

namespace App\Domain\ProjectUserDate;

use App\Domain\Date\DateEntity;
use App\Domain\Entities\Entity;
use App\Domain\Project\ProjectEntity;
use App\Domain\ProjectUser\ProjectUserEntity;
use App\Domain\Traits\EntityHelperTrait;
use App\Domain\User\UserEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="`project_user_date`")
 */
class ProjectUserDateEntity extends Entity
{
    use EntityHelperTrait;

    /**
     * @ORM\Column(name="`status`", type="integer", nullable=true)
     * @var integer
     */
    private int $status;

    /**
     * @ORM\Column(name="`mark`", type="integer", nullable=true)
     * @var integer
     */
    private int $mark;

    // Joins

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Date\DateEntity", cascade={"persist"})
     * @ORM\JoinColumn(name="date_id", referencedColumnName="id", onDelete="CASCADE")
     * @var DateEntity
     */
    private DateEntity $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\ProjectUser\ProjectUserEntity", cascade={"persist"})
     * @ORM\JoinColumn(name="project_user_id", referencedColumnName="id", onDelete="CASCADE")
     * @var ProjectUserEntity
     */
    private ProjectUserEntity $projectUser;


    /**
     * Entity constructor.
     * @param array $initData
     * @throws Exception
     */
    public function __construct(array $initData = [])
    {
        parent::__construct();

        $this->status = $initData['status'];
        $this->mark = $initData['mark'];
        $this->date = $initData['date'];
        $this->projectUser = $initData['projectUser'];
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
     * @return int
     */
    public function getMark(): int
    {
        return $this->mark;
    }

    /**
     * @param int $mark
     */
    public function setMark(int $mark): void
    {
        $this->mark = $mark;
    }

    /**
     * @return DateEntity
     */
    public function getDate(): DateEntity
    {
        return $this->date;
    }

    /**
     * @param DateEntity $date
     */
    public function setDate(DateEntity $date): void
    {
        $this->date = $date;
    }

    /**
     * @return ProjectUserEntity
     */
    public function getProjectUser(): ProjectUserEntity
    {
        return $this->projectUser;
    }

    /**
     * @param ProjectUserEntity $projectUser
     */
    public function setProjectUser(ProjectUserEntity $projectUser): void
    {
        $this->projectUser = $projectUser;
    }

}
