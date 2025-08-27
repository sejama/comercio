<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Debes aceptar nuestros términos.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese una contraseña.',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Tu contraseña debe tener al menos {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
