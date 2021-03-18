<?php

namespace App\Entity;

use App\Repository\OfertaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfertaRepository::class)
 */
class Oferta
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
    private $titol;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $descripcio;

    /**
     * @ORM\Column(type="date")
     */
    private $dataPublicacio;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ubicacio;

    /**
     * @ORM\Column(type="smallint")
     */
    private $estat;

    /**
     * @ORM\ManyToOne(targetEntity=Empresa::class, inversedBy="ofertes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $empresa;

    /**
     * @ORM\ManyToMany(targetEntity=Candidat::class, inversedBy="ofertes")
     */
    private $candidats;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class, inversedBy="ofertes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoria;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->titol;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitol(): ?string
    {
        return $this->titol;
    }

    public function setTitol(string $titol): self
    {
        $this->titol = $titol;

        return $this;
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

    public function getDataPublicacio(): ?\DateTimeInterface
    {
        return $this->dataPublicacio;
    }

    public function setDataPublicacio(\DateTimeInterface $dataPublicacio): self
    {
        $this->dataPublicacio = $dataPublicacio;

        return $this;
    }

    public function getUbicacio(): ?string
    {
        return $this->ubicacio;
    }

    public function setUbicacio(string $ubicacio): self
    {
        $this->ubicacio = $ubicacio;

        return $this;
    }

    public function getEstat(): ?int
    {
        return $this->estat;
    }

    public function setEstat(int $estat): self
    {
        $this->estat = $estat;

        return $this;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        $this->candidats->removeElement($candidat);

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }
}
