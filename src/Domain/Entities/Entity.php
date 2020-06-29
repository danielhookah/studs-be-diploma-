<?php

namespace App\Domain\Entities;

use App\Infrastructure\Shared\DTO\AbstractDTOInterface;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\ORM\PersistentCollection;
use Exception;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="`created`", type="datetime")
     * @var DateTime
     */
    protected DateTime $created;

    /**
     * @ORM\Column(name="`updated`", type="datetime")
     * @var DateTime
     */
    protected DateTime $updated;

    /**
     * Entity constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @throws Exception
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new DateTime());
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created->format('Y-m-d');
    }

    public function getCreatedLog()
    {
        return $this->created->format('Y-m-d h:i');
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

}
