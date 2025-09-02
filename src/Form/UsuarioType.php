<?php

namespace App\Form;

use App\Entity\Negocio;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'required' => true,
                'disabled' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese un nombre de usuario.',
                    ]),
                    new Length(
                        min: 3,
                        max: 100,
                        minMessage: 'Tu nombre de usuario debe tener al menos {{ limit }} caracteres',
                        maxMessage: 'Tu nombre de usuario no puede tener más de {{ limit }} caracteres',
                    )
                ],
            ])
            //->add('password')
            ->add('nombre', TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese su nombre.',
                    ]),
                ],
            ])
            ->add('apellido', TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese su apellido.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese un correo electrónico.',
                    ]),
                    new Length(
                        max: 180,
                        maxMessage: 'Tu correo electrónico no puede tener más de {{ limit }} caracteres',
                    ),
                ],
            ])
            //->add('isVerified')
            ->add('createdAt', null, [
                'widget' => 'single_text',
                'disabled' => true,
                
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
                'disabled' => true,
            ])
            /*
            ->add('lastConnection', null, [
                'widget' => 'single_text',
            ])
            ->add('negocios', EntityType::class, [
                'class' => Negocio::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
