<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Troupe;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Improvisator;
use App\Security\Voter\ContributorVoter;

class ImprovisatorController extends AbstractController
{
    /**
     * @Route("/improvisator", name="improvisator")
     */
    public function listImprovisators(EntityManagerInterface $em)
    {
        
        
        $repository = $em->getRepository(Improvisator::class);
        
        /** @var Improvisator[] $improvisators */
        $improvisators = $repository->findAll();
        
        $parameters = array(
            'improvisators' => $improvisators);
        
        return $this->render('improvisator/list_improvisators.html.twig', $parameters);
    }
    
    /**
     * @Route("/improvisator/new", name="improvisator_create")
     */
    public function troupeCreate()
    {
        
        
        
        return $this->render('improvisator/index.html.twig', [
            'controller_name' => 'GroupController',
        ]);
    }
    
    
    /**
     * @Route("/improvisator/{identifier}", name="improvisator_identifier")
     */
    public function troupeByShortName($identifier, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(improvisator::class);
        
        $improvisator = $repository->findOneBy(array("identifier" =>$identifier));
        
        return $this->render('improvisator/improvisator.html.twig', [
            'improvisator' =>$improvisator,
        ]);
    }
    
    /**
     * @Route("/improvisator/{identifier}/edit", name="improvisator_identifier_edit")
     */
    public function improvisatorEditByShortName($identifier, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Improvisator::class);
        
        $improvisator = $repository->findOneBy(array("identifier" =>$identifier));
        
        $this->denyAccessUnlessGranted(ContributorVoter::EDIT_CONTRIBUTOR, $improvisator);
        
        return $this->render('improvisator/improvisator.html.twig', [
            'improvisator' =>$improvisator,
        ]);
    }
}
