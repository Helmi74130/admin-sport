<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Gérants' => 'ROLE_LEADER',
                    'Structures' => 'ROLE_USER'
                ],
                'expanded'  => true, // liste déroulante
                'multiple'  => true, // choix multiple
                'label' => 'Définnisez les roles'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
        ;
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $hall = $event->getData();
            $form = $event->getForm();

            // checks if the Permission object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Hall"
            if (!$hall || null === $hall->getId()) {
                $form->add('hall',null, [
                    'mapped' => true,
                    'label' => 'Avec quelle salle souhaité(e) vous faire un lien?'
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
