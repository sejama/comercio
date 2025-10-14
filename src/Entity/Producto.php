<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $codigo = null;

    #[ORM\ManyToOne(inversedBy: 'productos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoriaProducto $categoria = null;

    #[ORM\Column]
    private ?float $precio_actual = null;

    #[ORM\Column(nullable: true)]
    private ?float $stock_actual = null;

    /**
     * @var Collection<int, PrecioHistorico>
     */
    #[ORM\OneToMany(targetEntity: PrecioHistorico::class, mappedBy: 'producto')]
    private Collection $precioHistoricos;

    /**
     * @var Collection<int, StockMovimiento>
     */
    #[ORM\OneToMany(targetEntity: StockMovimiento::class, mappedBy: 'producto')]
    private Collection $stockMovimientos;

    public function __construct()
    {
        $this->precioHistoricos = new ArrayCollection();
        $this->stockMovimientos = new ArrayCollection();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getCategoria(): ?CategoriaProducto
    {
        return $this->categoria;
    }

    public function setCategoria(?CategoriaProducto $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getPrecioActual(): ?float
    {
        return $this->precio_actual;
    }

    public function setPrecioActual(float $precio_actual): static
    {
        $this->precio_actual = $precio_actual;

        return $this;
    }

    public function getStockActual(): ?float
    {
        return $this->stock_actual;
    }

    public function setStockActual(?float $stock_actual): static
    {
        $this->stock_actual = $stock_actual;

        return $this;
    }

    /**
     * @return Collection<int, PrecioHistorico>
     */
    public function getPrecioHistoricos(): Collection
    {
        return $this->precioHistoricos;
    }

    public function addPrecioHistorico(PrecioHistorico $precioHistorico): static
    {
        if (!$this->precioHistoricos->contains($precioHistorico)) {
            $this->precioHistoricos->add($precioHistorico);
            $precioHistorico->setProducto($this);
        }

        return $this;
    }

    public function removePrecioHistorico(PrecioHistorico $precioHistorico): static
    {
        if ($this->precioHistoricos->removeElement($precioHistorico)) {
            // set the owning side to null (unless already changed)
            if ($precioHistorico->getProducto() === $this) {
                $precioHistorico->setProducto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StockMovimiento>
     */
    public function getStockMovimientos(): Collection
    {
        return $this->stockMovimientos;
    }

    public function addStockMovimiento(StockMovimiento $stockMovimiento): static
    {
        if (!$this->stockMovimientos->contains($stockMovimiento)) {
            $this->stockMovimientos->add($stockMovimiento);
            $stockMovimiento->setProducto($this);
        }

        return $this;
    }

    public function removeStockMovimiento(StockMovimiento $stockMovimiento): static
    {
        if ($this->stockMovimientos->removeElement($stockMovimiento)) {
            // set the owning side to null (unless already changed)
            if ($stockMovimiento->getProducto() === $this) {
                $stockMovimiento->setProducto(null);
            }
        }

        return $this;
    }
}
