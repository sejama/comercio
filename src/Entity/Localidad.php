<?php

namespace App\Entity;

use App\Repository\LocalidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalidadRepository::class)]
class Localidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToOne(inversedBy: 'localidades')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Provincia $provincia = null;

    /**
     * @var Collection<int, Sucursal>
     */
    #[ORM\OneToMany(targetEntity: Sucursal::class, mappedBy: 'localidad')]
    private Collection $sucursales;

    #[ORM\Column(length: 8)]
    private ?string $codigoPostal = null;

    public function __construct()
    {
        $this->sucursales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getProvincia(): ?Provincia
    {
        return $this->provincia;
    }

    public function setProvincia(?Provincia $provincia): static
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * @return Collection<int, Sucursal>
     */
    public function getSucursales(): Collection
    {
        return $this->sucursales;
    }

    public function addSucursale(Sucursal $sucursale): static
    {
        if (!$this->sucursales->contains($sucursale)) {
            $this->sucursales->add($sucursale);
            $sucursale->setLocalidad($this);
        }

        return $this;
    }

    public function removeSucursale(Sucursal $sucursale): static
    {
        if ($this->sucursales->removeElement($sucursale)) {
            // set the owning side to null (unless already changed)
            if ($sucursale->getLocalidad() === $this) {
                $sucursale->setLocalidad(null);
            }
        }

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(string $codigoPostal): static
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }
}
