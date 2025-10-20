<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Venta;
use App\Entity\VentaDetalle;
use PhpParser\Builder\Enum_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cliente', EntityType::class, [
                'class' => Cliente::class,
                'choice_label' => fn(Cliente $cliente) => $cliente->getApellido() . ' ' . $cliente->getNombre(),
            ])
            ->add('formaPago', EnumType::class, [
                'class' => 'App\Enum\VentaFormaPago',
                'choice_label' => fn($value) => $value->name,
            ])
            ->add('observacion')
            ->add('ventaDetalles', CollectionType::class, [
                'entry_type' => VentaDetalleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'entry_options' => ['label' => true],
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Venta::class,
        ]);
    }
}
