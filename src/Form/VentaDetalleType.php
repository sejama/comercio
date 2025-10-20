<?php

namespace App\Form;

use App\Entity\Producto;
use App\Entity\VentaDetalle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentaDetalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('producto', EntityType::class, [
                'class' => Producto::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione un producto',
                'choice_attr' => function (?Producto $producto, $key, $value) {
                    if (!$producto) return [];
                    return [
                        'data-price' => $producto->getPrecioActual(), // o getPrecio()
                        'data-min'   => 1,
                    ];
                },
            ])
            ->add('cantidad', 
                null, 
                ['attr' => ['min' => 1, 'step' => 1]])
            ->add('precioUnitario', null, 
                ['attr' => ['readonly' => true]])
            ->add('subtotal', null, 
                ['attr' => ['readonly' => true]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VentaDetalle::class,
        ]);
    }
}
