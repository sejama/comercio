<?php

namespace App\Form;

use App\Entity\CategoriaProducto;
use App\Entity\Producto;
use App\Entity\Sucursal;
use Dom\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre del Producto',
                'required' => true
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción del Producto',
                'required' => false
            ])
            ->add('codigo', null, [
                'label' => 'Código del Producto',
                'required' => true
            ])
            ->add('categoria', EntityType::class, [
                'class' => CategoriaProducto::class,
                'choice_label' => 'nombre',
                'label' => 'Categoría',
                'placeholder' => 'Seleccione una categoría',
                'required' => true,
            ])
            ->add('nueva_categoria', TextType::class, [
                'label' => 'Nueva Categoría',
                'required' => false,
                'mapped' => false,
                'label' => false,
                'attr' => ['style' => 'display:none;'],
            ])
            ->add('sucursal', EntityType::class, [
                'class' => Sucursal::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione una sucursal',
                'required' => false,
                'mapped' => false,
                'label' => false, 
                'attr' => ['style' => 'display:none;'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'categorias' => [],
            'sucursales' => [],
        ]);
    }
}
