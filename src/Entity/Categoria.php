<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriaRepository::class)
 */
class Categoria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $descripcio;

    /**
     * @ORM\OneToMany(targetEntity=Oferta::class, mappedBy="categoria")
     */
    private $ofertes;

    public function __construct()
    {
        $this->ofertes = new ArrayCollection();
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->descripcio;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcio(): ?string
    {
        return $this->descripcio;
    }

    public function setDescripcio(string $descripcio): self
    {
        $this->descripcio = $descripcio;

        return $this;
    }

    /**
     * @return Collection|Oferta[]
     */
    public function getOfertes(): Collection
    {
        return $this->ofertes;
    }

    public function addOferte(Oferta $oferte): self
    {
        if (!$this->ofertes->contains($oferte)) {
            $this->ofertes[] = $oferte;
            $oferte->setCategoria($this);
        }

        return $this;
    }

    public function removeOferte(Oferta $oferte): self
    {
        if ($this->ofertes->removeElement($oferte)) {
            // set the owning side to null (unless already changed)
            if ($oferte->getCategoria() === $this) {
                $oferte->setCategoria(null);
            }
        }

        return $this;
    }
}
