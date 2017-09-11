<?php

namespace AppBundle\Entity\Auth;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role as BaseRole;

/**
 * Class Role.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Auth\RoleRepository")
 */
class Role extends BaseRole
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    private $users;

    /**
     * @ORM\Column(name="role", type="string", length=60, unique=true)
     */
    private $role;

    /**
     * Role constructor.
     *
     * @param string $role
     */
    public function __construct(string $role)
    {
        parent::__construct($role);

        $this->role = $role;
        $this->users = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return \AppBundle\Entity\Auth\Role
     */
    public function setName(string $name): Role
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Add user.
     *
     * @param \AppBundle\Entity\Auth\User $user
     *
     * @return Role
     */
    public function addUser(User $user): Role
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addRole($this);
        }

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \AppBundle\Entity\Auth\User $user
     */
    public function removeUser(User $user): void
    {
        $user->removeRole($this);
        $this->users->removeElement($user);
    }
}
