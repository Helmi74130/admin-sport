<?php

namespace App\Form;

use App\Entity\Hall;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints as Assert;

class HallType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();
            // checks if the Permission object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Permission"
            if (!$user || null === $user->getId()) {
                $form->add('leaderHall',null, [
                    'mapped' => true,
                    'label' => 'Avec quelle gérant de SALLE souhaité(e) vous faire un lien?'
                ]);
            }
        });

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $leader = $event->getData();
            $form = $event->getForm();

            // checks if the Permission object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Permission"
            if (!$leader || null === $leader->getId()) {
                $form->add('leader',null, [
                    'mapped' => true,
                    'label' => 'Avec quelle gérant de FRANCHISE souhaité(e) vous faire un lien?'
                ]);
            }
        });
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la salle *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '150'
                ]

            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Courte déscription',
                'required' => false,
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '1000'
                ]
            ])
            ->add('streetNumber', IntegerType::class, [
                'label' => 'N° de rue *',
                'attr' => [
                    'minlength' => '1',
                    'maxlength' => '5'
                ],
                'constraints' => [
                    new Assert\Positive()
                ]
            ])
            ->add('adress', TextareaType::class, [
                'label'=> 'Adresse *'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '150'
                ]
            ])
            ->add('isactive', null, [
                'label' => 'En activitée *'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone *',
                'attr' => [
                    'minlength' => '10',
                    'maxlength' => '12'
                ]
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postale *',
                'attr' => [
                    'minlength' => '5',
                    'maxlength' => '6'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de la salle',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hall::class,
        ]);
    }
}
