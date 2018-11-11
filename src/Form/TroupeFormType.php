<?php

namespace App\Form;

use App\Entity\Troupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            //->add('superAdmins')
            //->add('admins')
            //->add('invitedToOpenDates')
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
