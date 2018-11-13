<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\Voter\ContributorVoter;
use App\Form\TeamSelectTroupeFromType;
use App\Entity\Team;

class TeamController extends AbstractController
{
    
   
    
    
    
    /**
     * @Route("/team/{identifier}/select_troupe",
     *      name="team_identifier_select_troupe",
     *      )
     */
    public function teamSelectTroupeFromTypeByShortName($identifier, EntityManagerInterface $em, Request $request)
    {
        
        $repository = $em->getRepository(Team::class);
        
        $contributor = $repository->findOneBy(array("identifier" =>$identifier));
        
        $this->denyAccessUnlessGranted(ContributorVoter::EDIT_CONTRIBUTOR, $contributor);
        
        
        $form = $this->createForm(TeamSelectTroupeFromType::class);
        $form->setData($contributor);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var Troupe $contributor */
            $contributor=$form->getData();
            
            $em->persist($contributor);
            $em->flush();
            
            
            $this->addFlash('success', 'Cool, the '.$contributor->getType().' has been updated!');
            return $this->redirectToRoute('contributor_identifier',array('identifier'=>$contributor->getIdentifier(), 'contributor_type' => $contributor->getType()));
            
            
        }
        
        return $this->render('contributor_abstract/contributor_edit.html.twig', [
            'contributor' => $contributor,
            'form'=>$form->createView()
        ]);
    }
    
    

}
