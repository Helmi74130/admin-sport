<?php

namespace App\Form;

use App\Entity\Hall;
use App\Entity\Permission;
use App\Repository\HallRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isSellDrinks',null, [
                'label'    => 'Peut-il vendre des boissons ?',
                'attr' => [
                    'id' => 'flexSwitchCheckChecked'
                ]
            ])
            ->add('isMembersWrite', null, [
                'label'    => 'Peut-il modifier un membre ?',
            ])
            ->add('isMembersRead', null, [
                'label'    => 'Peut-il avoir accés à un membre ?',
            ])
            ->add('isMembersAdd', null, [
                'label'    => 'Peut-il ajouter un membre ?',
            ])
            ->add('isMembersStatistiqueRead', null, [
                'label'    => 'Peut-il voir les statistique d\'un membre ?',
            ])
            ->add('isPaymentSchedulesWrite', null, [
                'label'    => 'Peut-il avoir accés aux échéanciés de paiement ?',
            ])
            ->add('isPaymentSchedulesAdd', null, [
                'label'    => 'Peut-il ajouter un échéancié de paiement ?',
            ])

        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $permission = $event->getData();
            $form = $event->getForm();

            // checks if the Leader object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Leader"
            if (!$permission || null === $permission->getId()) {
                $form->add('hall', EntityType::class, [
                    'class' => Hall::class,
                    'query_builder' => function(HallRepository $repository){
                        return $repository->createQueryBuilder('i')
                            ->orderBy('i.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'label' => 'Avec quelle salle souhaité(e) vous faire un lien?'
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Permission::class,
        ]);
    }
}
