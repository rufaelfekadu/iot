<?php

namespace App\Entity;

use App\Repository\ApplianceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplianceTypeRepository::class)
 */
class ApplianceType
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Appliance::class, mappedBy="type")
     * 
     */
    private $appliances;

    public function __construct()
    {
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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
            $appliance->setType($this);
        }

        return $this;
    }

    public function removeAppliance(Appliance $appliance): self
    {
        if ($this->appliances->removeElement($appliance)) {
            // set the owning side to null (unless already changed)
            if ($appliance->getType() === $this) {
                $appliance->setType(null);
            }
        }

        return $this;
    }
    public function __tostring(){
        return $this->name;
    }
}
