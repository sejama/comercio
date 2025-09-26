<?php

namespace App\Entity;

use App\Repository\SucursalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SucursalRepository::class)]
class Sucursal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sucursales')]
    private ?Negocio $negocio = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $domicilio = null;

    #[ORM\ManyToOne(inversedBy: 'sucursales')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localidad $localidad = null;

    /**
     * @var Collection<int, CategoriaProducto>
     */
    #[ORM\OneToMany(targetEntity: CategoriaProducto::class, mappedBy: 'sucursal')]
    private Collection $categoriaProductos;

    public function __construct()
    {
        $this->categoriaProductos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNegocio(): ?Negocio
    {
        return $this->negocio;
    }

    public function setNegocio(?Negocio $negocio): static
    {
        $this->negocio = $negocio;

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

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(string $domicilio): static
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function getLocalidad(): ?Localidad
    {
        return $this->localidad;
    }

    public function setLocalidad(?Localidad $localidad): static
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * @return Collection<int, CategoriaProducto>
     */
    public function getCategoriaProductos(): Collection
    {
        return $this->categoriaProductos;
    }

    public function addCategoriaProducto(CategoriaProducto $categoriaProducto): static
    {
        if (!$this->categoriaProductos->contains($categoriaProducto)) {
            $this->categoriaProductos->add($categoriaProducto);
            $categoriaProducto->setSucursal($this);
        }

        return $this;
    }

    public function removeCategoriaProducto(CategoriaProducto $categoriaProducto): static
    {
        if ($this->categoriaProductos->removeElement($categoriaProducto)) {
            // set the owning side to null (unless already changed)
            if ($categoriaProducto->getSucursal() === $this) {
                $categoriaProducto->setSucursal(null);
            }
        }

        return $this;
    }

}
