<?php

namespace AppBundle\Security\User;

use AppBundle\Entity\Auth\Role;
use AppBundle\Entity\Auth\User;
use Doctrine\Common\Persistence\ObjectManager;
use LightSaml\Model\Protocol\Response;
use LightSaml\SpBundle\Security\User\UserCreatorInterface;
use LightSaml\SpBundle\Security\User\UsernameMapperInterface;
use Stringy\Stringy;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserCreator.
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
     * @param ObjectManager           $objectManager
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

        if ($username !== null) {
            $slug = Stringy::create(strtok($username, '@'))->slugify()->trim();

            $user = new User();
            $user->setUsername($username);
            $user->setEmail($username);
            $user->setSlug($slug);

            $role = $this->objectManager->getRepository(Role::class)->findOneBy(['role' => 'ROLE_USER']);
            if ($role instanceof Role) {
                $user->addRole($role);
            }

            $this->objectManager->persist($user);
            $this->objectManager->flush();

            return $user;
        }

        return null;
    }
}
