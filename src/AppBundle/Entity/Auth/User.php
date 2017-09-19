<?php

namespace AppBundle\Entity\Auth;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class User.
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Auth\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @UniqueEntity("slug")
 * @Vich\Uploadable
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     */
    private $slug;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstname;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="user_picture", fileNameProperty="picture")
     * @Assert\Image(
     *     maxSize = "500k"
     * )
     */
    private $pictureFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
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
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set email.
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
     * Get email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $slug
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function setSlug(string $slug): User
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set firstname.
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
     * Get firstname.
     *
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
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
     * Get lastname.
     *
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set picturePath.
     *
     * @param null|string $picture
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function setPicture(?string $picture = null): User
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picturePath.
     *
     * @return null|string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param null|\Symfony\Component\HttpFoundation\File\File $file
     *
     * @return \AppBundle\Entity\Auth\User
     */
    public function setPictureFile(?File $file): User
    {
        $this->pictureFile = $file;

        if ($file instanceof File) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Get roles.
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
     */
    public function unserialize($serialized): void
    {
        list($this->id, $this->username, $this->roles) = unserialize($serialized);
    }

    /**
     * Add role.
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
     * Remove role.
     *
     * @param \AppBundle\Entity\Auth\Role $role
     */
    public function removeRole(Role $role): void
    {
        $this->roles->removeElement($role);
    }
}
