<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Troupe;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\Voter\ContributorVoter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TroupeFormType;

class TroupeController extends AbstractController
{
    /**
     * @Route("/troupe", name="troupe")
     */
    public function listTroupes(EntityManagerInterface $em)
    {
        
        
        $repository = $em->getRepository(Troupe::class);
        
        /** @var Troupe[] $troupes */
        $troupes = $repository->findAll();
        
        $parameters = array(
            'troupes' => $troupes);
        
        return $this->render('troupe/list_troupes.html.twig', $parameters);
    }
    
    /**
     * @Route("/troupe/new", name="troupe_create")
     */
    public function troupeCreate()
    {
        
        
        
        return $this->render('troupe/index.html.twig', [
            'controller_name' => 'GroupController',
        ]);
    }
    
    
    /**
     * @Route("/troupe/{identifier}", name="troupe_identifier")
     */
    public function troupeByShortName($identifier, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Troupe::class);
        
        $troupe = $repository->findOneBy(array("identifier" =>$identifier));
        
        return $this->render('troupe/troupe.html.twig', [
            'troupe' =>$troupe,
        ]);
    }
    
    /**
     * @Route("/troupe/{identifier}/edit", name="troupe_identifier_edit")
     */
    public function troupeEditByShortName($identifier, EntityManagerInterface $em, Request $request)
    {
        $repository = $em->getRepository(Troupe::class);
        
        $troupe = $repository->findOneBy(array("identifier" =>$identifier));

        $this->denyAccessUnlessGranted(ContributorVoter::EDIT_CONTRIBUTOR, $troupe);
        
        
        $troupeform = $this->createForm(TroupeFormType::class);
        $troupeform->handleRequest($request);
        
        if ($troupeform->isSubmitted() && $troupeform->isValid()) {
            $troupe->setName($troupeform->getData()->getName());
            $troupe->setDescription($troupeform->getData()->getDescription());
            $troupe->setShortName($troupeform->getData()->getShortName());
            $troupe->setLocation($troupeform->getData()->getLocation());
            $em->flush();
            
            //return $this->redirectToRoute('tasklist_id',array(
           //     'id'=>$tasklist->getId(),
            //    'slug'=>$tasklist->getSlug(),
              //  'from' => "update"
                
           // ));
        }else{
            $troupeform->setData($troupe);
        }
        
        return $this->render('troupe/troupe_edit.html.twig', [
            'troupe' =>$troupe,
            'troupeform'=>$troupeform->createView()
        ]);
    }
}
