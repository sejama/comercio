<?php

namespace App\Entity;

use App\Repository\NegocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NegocioRepository::class)]
class Negocio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Usuario>
     */
    #[ORM\ManyToMany(targetEntity: Usuario::class, inversedBy: 'negocios')]
    private Collection $dresponsable;

    /**
     * @var Collection<int, Sucursal>
     */
    #[ORM\OneToMany(targetEntity: Sucursal::class, mappedBy: 'negocio')]
    private Collection $sucursales;

    public function __construct()
    {
        $this->dresponsable = new ArrayCollection();
        $this->sucursales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Usuario>
     */
    public function getDresponsable(): Collection
    {
        return $this->dresponsable;
    }

    public function addDresponsable(Usuario $dresponsable): static
    {
        if (!$this->dresponsable->contains($dresponsable)) {
            $this->dresponsable->add($dresponsable);
        }

        return $this;
    }

    public function removeDresponsable(Usuario $dresponsable): static
    {
        $this->dresponsable->removeElement($dresponsable);

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
            $sucursale->setNegocio($this);
        }

        return $this;
    }

    public function removeSucursale(Sucursal $sucursale): static
    {
        if ($this->sucursales->removeElement($sucursale)) {
            // set the owning side to null (unless already changed)
            if ($sucursale->getNegocio() === $this) {
                $sucursale->setNegocio(null);
            }
        }

        return $this;
    }
}
