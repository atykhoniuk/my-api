<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\RolesRepository")
 */
class Roles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserRoles", mappedBy="role")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RolesPermissions", mappedBy="role")
     */
    private $rolesPermissions;











    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
        $this->testRoles = new ArrayCollection();
        $this->rolesPermissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|UserRoles[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(UserRoles $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->setRole($this);
        }

        return $this;
    }

    public function removeUserRole(UserRoles $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            // set the owning side to null (unless already changed)
            if ($userRole->getRole() === $this) {
                $userRole->setRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RolesPermissions[]
     */
    public function getRolesPermissions(): Collection
    {
        return $this->rolesPermissions;
    }

    public function addRolesPermission(RolesPermissions $rolesPermission): self
    {
        if (!$this->rolesPermissions->contains($rolesPermission)) {
            $this->rolesPermissions[] = $rolesPermission;
            $rolesPermission->setRole($this);
        }

        return $this;
    }

    public function removeRolesPermission(RolesPermissions $rolesPermission): self
    {
        if ($this->rolesPermissions->contains($rolesPermission)) {
            $this->rolesPermissions->removeElement($rolesPermission);
            // set the owning side to null (unless already changed)
            if ($rolesPermission->getRole() === $this) {
                $rolesPermission->setRole(null);
            }
        }

        return $this;
    }


}
