<?php

namespace App\Form;

use App\Entity\Localidad;
use App\Entity\Negocio;
use App\Entity\Pais;
use App\Entity\Provincia;
use App\Entity\Sucursal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SucursalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('domicilio')
            ->add('sucursal_pais', EntityType::class, [
                'class' => Pais::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione un país',
                'mapped' => false, // No se guarda en la entidad
                
            ])
            ->add('sucursal_provincia', EntityType::class, [
                'class' => Provincia::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione una provincia',
                'mapped' => false, // No se guarda en la entidad
            ])
            ->add('localidad', EntityType::class, [
                'class' => Localidad::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione una localidad',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sucursal::class,
        ]);
    }
}
