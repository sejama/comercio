<?php

namespace App\Entity;

use App\Enum\VentaEstado;
use App\Enum\VentaFormaPago;
use App\Repository\VentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentaRepository::class)]
class Venta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    private ?Cliente $cliente = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\Column(nullable: true)]
    private ?float $total = null;

    #[ORM\Column(enumType: VentaEstado::class)]
    private ?VentaEstado $estado = null;

    #[ORM\Column(enumType: VentaFormaPago::class)]
    private ?VentaFormaPago $formaPago = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observacion = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, VentaDetalle>
     */
    #[ORM\OneToMany(targetEntity: VentaDetalle::class, mappedBy: 'venta')]
    private Collection $ventaDetalles;

    /**
     * @var Collection<int, Pago>
     */
    #[ORM\OneToMany(targetEntity: Pago::class, mappedBy: 'venta')]
    private Collection $pagos;

    public function __construct()
    {
        $this->ventaDetalles = new ArrayCollection();
        $this->pagos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    #[ORM\PrePersist]
    public function setFecha(): static
    {
        $this->fecha = new \DateTimeImmutable('now', new \DateTimeZone('America/Argentina/Buenos_Aires'));

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getEstado(): ?VentaEstado
    {
        return $this->estado;
    }

    public function setEstado(VentaEstado $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getFormaPago(): ?VentaFormaPago
    {
        return $this->formaPago;
    }

    public function setFormaPago(VentaFormaPago $formaPago): static
    {
        $this->formaPago = $formaPago;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): static
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
    
    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('America/Argentina/Buenos_Aires'));

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('America/Argentina/Buenos_Aires'));

        return $this;
    }

    /**
     * @return Collection<int, VentaDetalle>
     */
    public function getVentaDetalles(): Collection
    {
        return $this->ventaDetalles;
    }

    public function addVentaDetalle(VentaDetalle $ventaDetalle): static
    {
        if (!$this->ventaDetalles->contains($ventaDetalle)) {
            $this->ventaDetalles->add($ventaDetalle);
            $ventaDetalle->setVenta($this);
        }

        return $this;
    }

    public function removeVentaDetalle(VentaDetalle $ventaDetalle): static
    {
        if ($this->ventaDetalles->removeElement($ventaDetalle)) {
            // set the owning side to null (unless already changed)
            if ($ventaDetalle->getVenta() === $this) {
                $ventaDetalle->setVenta(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pago>
     */
    public function getPagos(): Collection
    {
        return $this->pagos;
    }

    public function addPago(Pago $pago): static
    {
        if (!$this->pagos->contains($pago)) {
            $this->pagos->add($pago);
            $pago->setVenta($this);
        }

        return $this;
    }

    public function removePago(Pago $pago): static
    {
        if ($this->pagos->removeElement($pago)) {
            // set the owning side to null (unless already changed)
            if ($pago->getVenta() === $this) {
                $pago->setVenta(null);
            }
        }

        return $this;
    }
}
