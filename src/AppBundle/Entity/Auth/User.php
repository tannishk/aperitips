<?php

namespace AppBundle\Entity\Auth;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @package AppBundle\Entity\Auth
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface, \Serializable
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastname;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $picturePath;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    protected $roles;

    /**
     * User constructor.
     *
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Set picturePath
     *
     * @param string $picturePath
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function setPicturePath(string $picturePath): User
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    /**
     * Get picturePath
     *
     * @return string
     */
    public function getPicturePath(): string
    {
        return $this->picturePath;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles->toArray();
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return '';
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return '';
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->username, $this->roles]);
    }

    /**
     * @param string $serialized
     *
     * @return void
     */
    public function unserialize($serialized): void
    {
        list($this->id, $this->username, $this->roles) = unserialize($serialized);
    }

    /**
     * Add role
     *
     * @param \AppBundle\Entity\Auth\Role $role
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function addRole(Role $role): User
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }

    /**
     * Remove role
     *
     * @param \AppBundle\Entity\Auth\Role $role
     *
     * @return void
     */
    public function removeRole(Role $role): void
    {
        $this->roles->removeElement($role);
    }
}