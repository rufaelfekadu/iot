<?php

namespace App\Entity;

use App\Repository\OfficeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfficeRepository::class)
 */
class Office
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="office")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Appliance::class, mappedBy="office")
     */
    private $appliances;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->appliances = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setOffice($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOffice() === $this) {
                $user->setOffice(null);
            }
        }

        return $this;
    }
    public function __tostring(){
        return $this->name;
    }

    /**
     * @return Collection|Appliance[]
     */
    public function getAppliances(): Collection
    {
        return $this->appliances;
    }

    public function addAppliance(Appliance $appliance): self
    {
        if (!$this->appliances->contains($appliance)) {
            $this->appliances[] = $appliance;
            $appliance->setOffice($this);
        }

        return $this;
    }

    public function removeAppliance(Appliance $appliance): self
    {
        if ($this->appliances->removeElement($appliance)) {
            // set the owning side to null (unless already changed)
            if ($appliance->getOffice() === $this) {
                $appliance->setOffice(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
