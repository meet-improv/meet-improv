<?php

namespace App\Form;

use App\Entity\OpenDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Contributor;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OpenDateCreateFormType extends AbstractType
{
    private $tokenStorage;
    
    public function __construct(TokenStorageInterface $tokenStorage){
        $this->tokenStorage = $tokenStorage;
    }
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        /** var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $builder
            //->add('id')
            ->add('start')
            ->add('end')
            ->add('isPublic')
            ->add('isClosed')
            ->add('name')
            ->add('description')
            ->add('owner',EntityType::class,[
                'class' => Contributor::class,
                'choices' => $user->getAdminOfContributors(),
                'choice_value' => 'identifier',
                'choice_label' => 'identifier'
            ])
            ->add('Save', SubmitType::class)
            //->add('invitedContributors')
            //->add('createdBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OpenDate::class,
        ]);
    }
}
