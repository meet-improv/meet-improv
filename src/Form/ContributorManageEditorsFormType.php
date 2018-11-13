<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\Contributor;

class ContributorManageEditorsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              
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
            
     /*   
        ->add('improvisators', EntityType::class,[
            'class' => Improvisator::class,
            'choice_value' => 'identifier',
            'choice_label' => 'identifier',
            'mapped' => null,
            'multiple' => true
        ])*/
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contributor::class,
        ]);
    }
}
