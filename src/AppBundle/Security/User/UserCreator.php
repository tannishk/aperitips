<?php

namespace AppBundle\Security\User;

use AppBundle\Entity\Auth\Role;
use AppBundle\Entity\Auth\User;
use Doctrine\Common\Persistence\ObjectManager;
use LightSaml\Model\Protocol\Response;
use LightSaml\SpBundle\Security\User\UserCreatorInterface;
use LightSaml\SpBundle\Security\User\UsernameMapperInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserCreator
 *
 * @package AppBundle\Security\User
 */
class UserCreator implements UserCreatorInterface
{

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var UsernameMapperInterface
     */
    private $usernameMapper;

    /**
     * @param ObjectManager $objectManager
     * @param UsernameMapperInterface $usernameMapper
     */
    public function __construct($objectManager, $usernameMapper)
    {
        $this->objectManager = $objectManager;
        $this->usernameMapper = $usernameMapper;
    }

    /**
     * @param Response $response
     *
     * @return UserInterface|null
     */
    public function createUser(Response $response): ?UserInterface
    {
        $username = $this->usernameMapper->getUsername($response);

        $user = new User();
        $user->setUsername($username)->setEmail($username);

        $role = $this->objectManager->getRepository('AppBundle:Auth\Role')->findOneBy(['role' => 'ROLE_USER']);
        if ($role instanceof Role) {
            $user->addRole($role);
        }

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;
    }
}
