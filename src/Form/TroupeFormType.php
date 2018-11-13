<?php

namespace App\Form;

use App\Entity\Troupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Doctrine\ORM\PersistentCollection;
use App\Entity\Improvisator;

class TroupeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('id')
            ->add('name')
            ->add('description')
            ->add('shortName')
            //->add('identifier')
            ->add('location')
            //->add('createdAt')
            //->add('updatedAt')
        //->add('createdBy')
   /*     ->add('createdBy', EntityType::class,[
            'class' => User::class,
            'choice_value' => 'username',
            
        ])   */
        ->add('superAdmins', EntityType::class,[
            'class' => User::class,
            'choice_value' => 'username',
            'choice_label' => 'username',
            'multiple' => true
        ])
        ->add('admins', EntityType::class,[
            'class' => User::class,
            'choice_value' => 'username',
            'choice_label' => 'username',
            'multiple' => true
        ])
            //->add('invitedToOpenDates')
        
        ->add('improvisators', EntityType::class,[
            'class' => Improvisator::class,
            'choice_value' => 'identifier',
            'choice_label' => 'identifier',
            'mapped' => null,
            'multiple' => true
        ])
            ->add('update', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Troupe::class,
        ]);
    }
}
