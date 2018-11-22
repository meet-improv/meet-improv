<?php

namespace App\Form;

use App\Entity\OpenDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Contributor;

class OpenDateInvitationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
        //all contributor...
        ->add('invitedContributors',EntityType::class,[
            'class' => Contributor::class,
            'choice_value' => 'identifier',
            'choice_label' => 'identifier',
            'multiple' => true,
            //'mapped' => null,
        ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OpenDate::class,
        ]);
    }
}
