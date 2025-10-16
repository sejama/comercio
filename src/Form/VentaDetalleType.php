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
            ->add('cantidad')
            ->add('producto', EntityType::class, [
                'class' => Producto::class,
                'choice_label' => 'nombre',
            ])
            ->add('precioUnitario')
            ->add('subtotal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VentaDetalle::class,
        ]);
    }
}
