<?php

namespace App\Entity;

use App\Entity\Profondeur;

use App\Repository\TablePlongeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TablePlongeeRepository::class)
 */
class TablePlongee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=profondeur::class, mappedBy="table_plongee_id")
     */
    private $correspond;

    public function __construct()
    {
        $this->correspond = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|profondeur[]
     */
    public function getCorrespond(): Collection
    {
        return $this->correspond;
    }

    public function addCorrespond(profondeur $correspond): self
    {
        if (!$this->correspond->contains($correspond)) {
            $this->correspond[] = $correspond;
            $correspond->setTablePlongeeId($this);
        }

        return $this;
    }

    public function removeCorrespond(profondeur $correspond): self
    {
        if ($this->correspond->removeElement($correspond)) {
            // set the owning side to null (unless already changed)
            if ($correspond->getTablePlongeeId() === $this) {
                $correspond->setTablePlongeeId(null);
            }
        }

        return $this;
    }
}
