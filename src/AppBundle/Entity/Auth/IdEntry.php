<?php

namespace AppBundle\Entity\Auth;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class IdEntry.
 *
 * @ORM\Entity()
 */
class IdEntry
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $entityId;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $expiryTimestamp;

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     *
     * @return IdEntry
     */
    public function setEntityId($entityId): IdEntry
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return IdEntry
     */
    public function setId($id): IdEntry
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiryTime(): DateTime
    {
        return (new DateTime())->setTimestamp($this->expiryTimestamp);
    }

    /**
     * @param \DateTime $expiryTime
     *
     * @return IdEntry
     */
    public function setExpiryTime(DateTime $expiryTime): IdEntry
    {
        $this->expiryTimestamp = $expiryTime->getTimestamp();

        return $this;
    }
}
