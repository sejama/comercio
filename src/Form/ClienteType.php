<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Localidad;
use App\Entity\Negocio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('correo')
            ->add('telefono')
            ->add('celular')
            ->add('domicilio')
            ->add('localidad', EntityType::class, [
                'class' => Localidad::class,
                'choice_label' => 'id',
            ])
            ->add('negocio', EntityType::class, [
                'class' => Negocio::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
        ]);
    }
}
