<?php

namespace App\Form;

use App\Entity\Leader;;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


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
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            // checks if the Permission object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Permission"
            if (!$user || null === $user->getId()) {
                $form->add('user',null, [
                    'mapped' => true,
                    'label' => 'Avec quelle gérant de FRANCHISE souhaité(e) vous faire un lien?'
                ]);
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
