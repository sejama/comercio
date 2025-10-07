<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Localidad;
use App\Entity\Negocio;
use App\Entity\Pais;
use App\Entity\Provincia;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $cliente = $options['data'] ?? null;
        $provinciaSelected = null;
        $paisSelected = null;

        if ($cliente instanceof \App\Entity\Cliente && $cliente->getLocalidad()) {
            $provinciaSelected = $cliente->getLocalidad()->getProvincia();
            if ($provinciaSelected) {
                $paisSelected = $provinciaSelected->getPais();
            }
        }

        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('correo')
            ->add('telefono')
            ->add('celular')
            ->add('domicilio')
            ->add('pais', EntityType::class, [
                'class' => Pais::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione un país',
                'mapped' => false, // No se guarda en la entidad
                'data' => $paisSelected, // precarga país si existe
                
            ])
            ->add('provincia', EntityType::class, [
                'class' => Provincia::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione una provincia',
                'mapped' => false, // No se guarda en la entidad
                'data' => $provinciaSelected, // precarga provincia si existe
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
            'data_class' => Cliente::class,
        ]);
    }
}
