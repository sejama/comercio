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
    private Collection $responsable;

    /**
     * @var Collection<int, Sucursal>
     */
    #[ORM\OneToMany(targetEntity: Sucursal::class, mappedBy: 'negocio')]
    private Collection $sucursales;

    /**
     * @var Collection<int, Cliente>
     */
    #[ORM\OneToMany(targetEntity: Cliente::class, mappedBy: 'negocio', orphanRemoval: true)]
    private Collection $clientes;

    public function __construct()
    {
        $this->responsable = new ArrayCollection();
        $this->sucursales = new ArrayCollection();
        $this->clientes = new ArrayCollection();
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
    public function getResponsable(): Collection
    {
        return $this->responsable;
    }

    public function addResponsable(Usuario $responsable): static
    {
        if (!$this->responsable->contains($responsable)) {
            $this->responsable->add($responsable);
        }

        return $this;
    }

    public function removeResponsable(Usuario $responsable): static
    {
        $this->responsable->removeElement($responsable);

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

    /**
     * @return Collection<int, Cliente>
     */
    public function getClientes(): Collection
    {
        return $this->clientes;
    }

    public function addCliente(Cliente $cliente): static
    {
        if (!$this->clientes->contains($cliente)) {
            $this->clientes->add($cliente);
            $cliente->setNegocio($this);
        }

        return $this;
    }

    public function removeCliente(Cliente $cliente): static
    {
        if ($this->clientes->removeElement($cliente)) {
            // set the owning side to null (unless already changed)
            if ($cliente->getNegocio() === $this) {
                $cliente->setNegocio(null);
            }
        }

        return $this;
    }
}
