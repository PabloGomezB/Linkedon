<?php

namespace App\Entity;

use App\Repository\EmpresaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpresaRepository::class)
 */
class Empresa
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $tipus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $correu;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true )
     */
    private $usuari;

    /**
     * @ORM\OneToMany(targetEntity=Oferta::class, mappedBy="empresa")
     */
    private $ofertes;

    public function __construct()
    {
        $this->ofertes = new ArrayCollection();
    }

    public function __toString()
    {
    // TODO: Implement __toString() method.
        return $this->nom;
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

    public function getTipus(): ?string
    {
        return $this->tipus;
    }

    public function setTipus(?string $tipus): self
    {
        $this->tipus = $tipus;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCorreu(): ?string
    {
        return $this->correu;
    }

    public function setCorreu(?string $correu): self
    {
        $this->correu = $correu;

        return $this;
    }

    public function getUsuari(): ?User
    {
        return $this->usuari;
    }

    public function setUsuari(User $usuari): self
    {
        $this->usuari = $usuari;

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
            $oferte->setEmpresa($this);
        }

        return $this;
    }

    public function removeOferte(Oferta $oferte): self
    {
        if ($this->ofertes->removeElement($oferte)) {
            // set the owning side to null (unless already changed)
            if ($oferte->getEmpresa() === $this) {
                $oferte->setEmpresa(null);
            }
        }

        return $this;
    }
}
