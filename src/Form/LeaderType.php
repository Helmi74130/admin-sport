<?php

namespace App\Form;

use App\Entity\Leader;;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class LeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Nom *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
            ->add('civility', ChoiceType::class, [
                'label' => 'Civilité *',
                'choices'  => [
                    'Mme' => 'Mme',
                    'Mr' => 'Mr',
                    ]
                ])
            ->add('firstname', TextType::class, [
                'label'=> 'Prénom *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
            ->add('email', EmailType::class, [
                'label'=> 'E-mail *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
            ->add('city', TextType::class, [
                'label'=> 'Ville *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '80'
                ]
            ])
            ->add('phone', TelType::class, [
                'label'=> 'Tél. *',
                'attr' => [
                    'minlength' => '10',
                    'maxlength' => '15'
                ]
            ])
            ->add('commercialPhone', TelType::class, [
                'label'=> 'Tél. commercial',
                'required' => false,
                'attr' => [
                    'minlength' => '10',
                    'maxlength' => '15'
                ]
            ])
            ->add('isActive', null, [
                'label'=> 'En activité *'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Gérant de franchise' => 'ROLE_LEADER',
                ],
                'expanded'  => true, // liste déroulante
                'multiple'  => true, // choix multiple
                'label' => 'Rôle *'
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $leader = $event->getData();
            $form = $event->getForm();

            // checks if the Permission object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Password"
            if (!$leader || null === $leader->getId()) {
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

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Leader::class,
        ]);
    }
}
