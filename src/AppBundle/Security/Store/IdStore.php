<?php

namespace AppBundle\Security\Store;

use AppBundle\Entity\Auth\IdEntry;
use Doctrine\Common\Persistence\ObjectManager;
use LightSaml\Provider\TimeProvider\TimeProviderInterface;
use LightSaml\Store\Id\IdStoreInterface;

/**
 * Class IdStore
 *
 * @package AppBundle\Security\Store
 */
class IdStore implements IdStoreInterface
{

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var  TimeProviderInterface
     */
    private $timeProvider;

    /**
     * @param ObjectManager $manager
     * @param TimeProviderInterface $timeProvider
     */
    public function __construct(ObjectManager $manager, TimeProviderInterface $timeProvider)
    {
        $this->manager = $manager;
        $this->timeProvider = $timeProvider;
    }

    /**
     * @param string $entityId
     * @param string $id
     * @param \DateTime $expiryTime
     *
     * @return void
     */
    public function set($entityId, $id, \DateTime $expiryTime): void
    {
        $idEntry = $this->manager->find(IdEntry::class, ['entityId' => $entityId, 'id' => $id]);
        if (null == $idEntry) {
            $idEntry = new IdEntry();
        }

        $idEntry->setEntityId($entityId)->setId($id)->setExpiryTime($expiryTime);

        $this->manager->persist($idEntry);
        $this->manager->flush();
    }

    /**
     * @param string $entityId
     * @param string $id
     *
     * @return bool
     */
    public function has($entityId, $id): bool
    {
        /** @var IdEntry $idEntry */
        $idEntry = $this->manager->find(IdEntry::class, ['entityId' => $entityId, 'id' => $id]);
        if (null == $idEntry) {
            return false;
        }

        if ($idEntry->getExpiryTime()->getTimestamp() < $this->timeProvider->getTimestamp()) {
            return false;
        }

        return true;
    }
}