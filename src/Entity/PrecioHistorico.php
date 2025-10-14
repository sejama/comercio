<?php

namespace App\Entity;

use App\Repository\PrecioHistoricoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrecioHistoricoRepository::class)]
class PrecioHistorico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'precioHistoricos')]
    private ?Producto $producto = null;

    #[ORM\Column]
    private ?float $precio = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fecha_desde = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $fecha_hasta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): static
    {
        $this->producto = $producto;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getFechaDesde(): ?\DateTimeImmutable
    {
        return $this->fecha_desde;
    }

    public function setFechaDesde(\DateTimeImmutable $fecha_desde): static
    {
        $this->fecha_desde = $fecha_desde;

        return $this;
    }

    public function getFechaHasta(): ?\DateTimeImmutable
    {
        return $this->fecha_hasta;
    }

    public function setFechaHasta(?\DateTimeImmutable $fecha_hasta): static
    {
        $this->fecha_hasta = $fecha_hasta;

        return $this;
    }
}
