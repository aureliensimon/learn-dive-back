<?php

namespace App\Entity;

use App\Entity\Temps;

use App\Repository\ProfondeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfondeurRepository::class)
 */
class Profondeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $profondeur;

    /**
     * @ORM\ManyToOne(targetEntity=TablePlongee::class, inversedBy="correspond")
     * @ORM\JoinColumn(nullable=false)
     */
    private $table_plongee_id;

    /**
     * @ORM\OneToMany(targetEntity=temps::class, mappedBy="profondeur_id")
     */
    private $est_a;

    public function __construct()
    {
        $this->est_a = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfondeur(): ?int
    {
        return $this->profondeur;
    }

    public function setProfondeur(int $profondeur): self
    {
        $this->profondeur = $profondeur;

        return $this;
    }

    public function getTablePlongeeId(): ?TablePlongee
    {
        return $this->table_plongee_id;
    }

    public function setTablePlongeeId(?TablePlongee $table_plongee_id): self
    {
        $this->table_plongee_id = $table_plongee_id;

        return $this;
    }

    /**
     * @return Collection|temps[]
     */
    public function getEstA(): Collection
    {
        return $this->est_a;
    }

    public function addEstA(temps $estA): self
    {
        if (!$this->est_a->contains($estA)) {
            $this->est_a[] = $estA;
            $estA->setProfondeurId($this);
        }

        return $this;
    }

    public function removeEstA(temps $estA): self
    {
        if ($this->est_a->removeElement($estA)) {
            // set the owning side to null (unless already changed)
            if ($estA->getProfondeurId() === $this) {
                $estA->setProfondeurId(null);
            }
        }

        return $this;
    }
}
