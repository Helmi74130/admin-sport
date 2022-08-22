<?php

namespace App\Form;

use App\Entity\Permission;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isSellDrinks', CheckboxType::class,[
                'attr' => ['checked'   => 'checked'],
                'label'    => 'Peut-il vendre des boissons ?',
            ])
            ->add('isMembersWrite', CheckboxType::class, [
                'attr' => ['checked'   => 'checked'],
                'label'    => 'Peut-il modifier un membre ?',
            ])
            ->add('isMembersRead', CheckboxType::class, [
                'attr' => ['checked'   => 'checked'],
                'label'    => 'Peut-il voir un membre ?',
            ])
            ->add('isMembersAdd', CheckboxType::class, [
                'attr' => ['checked'   => 'checked'],
                'label'    => 'Peut-il ajouter un membre ?',
            ])
            ->add('isMembersStatistiqueRead', CheckboxType::class, [
                'attr' => ['checked'   => 'checked'],
                'label'    => 'Peut-il voir les statistique d\'un membre ?',
            ])
            ->add('isPaymentSchedulesWrite', CheckboxType::class, [
                'attr' => ['checked'   => 'checked'],
                'label'    => 'Peut-il avoir accés aux échéanciés de paiement ?',
            ])
            ->add('isPaymentSchedulesAdd', CheckboxType::class, [
                'attr' => ['checked'   => 'checked'],
                'label'    => 'Peut-il ajouter un échéancié de paiement ?',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Permission::class,
        ]);
    }
}
