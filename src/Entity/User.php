<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *     itemOperations={
 *          "get"={
 *                  "access_control"="is_granted('ROLE_SUPERADMIN')"
 *                 }
 *     },
 *     collectionOperations={"post"},
 *     normalizationContext={
 *          "groups"={"read"}
 *     }
 * )
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @UniqueEntity("phoneNum")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Assert\NotBlank()
     */
    private $fio;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=6,max=255)
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="Password must be seven characters long and contain at least one digit, one upper case and one lower case letter"
     * )
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Expression(
     *     "this.getPassword()==this.getRetypedPassword()",
     *     message="Password does not match"
     * )
     */
    private $retypedPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Assert\NotBlank()
     * @Assert\Length(min=10,max=10)
     */
    private $phoneNum;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Assert\NotBlank()
     *
     */
    private $birthdaydate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank()
     */
    private $sex;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Publication", mappedBy="user", orphanRemoval=true)
     * @Groups({"read"})
     */
    private $publications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     * @Groups({"read"})
     */
    private $comments;

    /**
     * @var Collection|Roles[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Roles", inversedBy="users")
     *@ORM\JoinTable(
     *      name="user_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="roles_id", referencedColumnName="id")}
     * )
     */
    private $roles;






















    public function __construct()
    {
        $this->publications = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->roles = new ArrayCollection();


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFio(): ?string
    {
        return $this->fio;
    }

    public function setFio(string $fio): self
    {
        $this->fio = $fio;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->fio;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhoneNum(): ?string
    {
        return $this->phoneNum;
    }

    public function setPhoneNum(string $phoneNum): self
    {
        $this->phoneNum = $phoneNum;

        return $this;
    }

    public function getBirthdaydate(): ?string
    {
        return $this->birthdaydate;
    }

    public function setBirthdaydate(string $birthdaydate): self
    {
        $this->birthdaydate = $birthdaydate;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }



    /**
     * @inheritDoc
     */
    public function getRoles1()
    {
       return ['ROLE_SUPERADMIN'];
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }


    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }


    public function getRetypedPassword()
    {
        return $this->retypedPassword;
    }


    public function setRetypedPassword($retypedPassword): void
    {
        $this->retypedPassword = $retypedPassword;
    }


    public function setRoles(Collection $roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return array_map(
            function ($role) {
                return $role->getName();
            },
            $this->roles->toArray()
        );
    }







}
