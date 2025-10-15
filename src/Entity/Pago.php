<?php

namespace App\Entity;

use App\Enum\VentaFormaPago;
use App\Repository\PagoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagoRepository::class)]
class Pago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pagos')]
    private ?Venta $venta = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\Column(enumType: VentaFormaPago::class)]
    private ?VentaFormaPago $formaPago = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referencia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenta(): ?Venta
    {
        return $this->venta;
    }

    public function setVenta(?Venta $venta): static
    {
        $this->venta = $venta;

        return $this;
    }

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeImmutable $fecha): static
    {
        $this->fecha = $fecha;

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

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(?string $referencia): static
    {
        $this->referencia = $referencia;

        return $this;
    }
}
