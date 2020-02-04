<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\RolesPermissionsRepository")
 */
class RolesPermissions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles", inversedBy="rolesPermissions")
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Permissions", inversedBy="rolesPermissions")
     */
    private $permission;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?Roles
    {
        return $this->role;
    }

    public function setRole(?Roles $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPermission(): ?Permissions
    {
        return $this->permission;
    }

    public function setPermission(?Permissions $permission): self
    {
        $this->permission = $permission;

        return $this;
    }
}
