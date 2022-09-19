<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('roles', ChoiceType::class, [
                    'required' => true,
                    'choices' => [
                        'GERANT DE FRANCHISE' => 'ROLE_LEADER',
                        'GERANT DE SALLE' => 'ROLE_USER'
                    ],
                    'expanded' => true, // liste déroulante
                    'multiple' => false, // choix multiple
                    'label' => 'Rôle *']
            )
            ->add('civility', ChoiceType::class, [
                'required' => true,
                'label' => 'Civilité *',
                'choices'  => [
                    'Mme' => 'Mme',
                    'Mr' => 'Mr',
                ]
            ])
            ->add('isActive', null, [
                'label'    => 'En activité ?',
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville'
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Prénom *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
            ->add('phone', TelType::class, [
                'required' => true,
                'label'=> 'Tél. *',
                'attr' => [
                    'minlength' => '10',
                    'maxlength' => '15'
                ]
            ]);
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            // checks if the Permission object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Password"
            if (!$user || null === $user->getId()) {
                $form->add('password', PasswordType::class, [
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'mapped' => false,
                    'attr' => ['autocomplete' => 'new-password'],
                    'label' => 'Mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ])
                ;
            }
        });
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
       $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            // checks if the Permission object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Hall"
            if (!$user || null === $user->getId()) {
                $form->add('email',EmailType::class, [
                    'label' => 'Adresse E-mail'
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
