<?php

namespace App\Form;

use App\Entity\Negocio;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NegocioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('sucursal', SucursalType::class, [
                'label' => false,
                'mapped' => false, // Si no tienes la relación en la entidad Negocio
                'required' => true,
            ])
            /*->add('responsable', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Negocio::class,
        ]);
    }
}
