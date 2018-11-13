<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Troupe;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\Voter\ContributorVoter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TroupeFormType;
use App\Entity\Membership;

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
     * @Route("/new/troupe", name="troupe_create")
     */
    public function troupeCreate(EntityManagerInterface $em, Request $request)
    {
        
        $repository = $em->getRepository(Troupe::class);
        
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $troupeform = $this->createForm(TroupeFormType::class);
        
        $troupeform->handleRequest($request);
        
        if ($troupeform->isSubmitted() && $troupeform->isValid()) {
            /**
             * 
             * @var Troupe $troupe
             */
            $troupe=$troupeform->getData();
            $troupe->setCreatedBy($this->getUser())->addAdmin($this->getUser())->addSuperAdmin($this->getUser());
            
            
            $em->persist($troupe);
            $em->flush();
            
            $this->addFlash('success', 'Troupe has been created!');
            
            return $this->redirectToRoute('troupe_identifier',array('identifier'=>$troupe->getIdentifier()));
            
        }
        $troupe = new Troupe();
        
        return $this->render('troupe/troupe_edit.html.twig', [
            'troupe' =>$troupe,
            'troupeform'=>$troupeform->createView()
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
        $troupeform->setData($troupe);
        $troupeform->handleRequest($request);
        
        if ($troupeform->isSubmitted() && $troupeform->isValid()) {
            /**
             *
             * @var Troupe $troupe
             */
            $troupe=$troupeform->getData();
            
             $improvisators = $troupeform->getRoot()->get("improvisators")->getData();
            
             $date = new \DateTime("01-03-2014");
             /** @var Improvisator $improvisator  */
             foreach ($improvisators as $improvisator){
                // dd($improvisator);
                 
                 $m = new Membership();
                 
                 $m->setImprovGroup($troupe)
                    ->setIsHidden(false)
                    ->setRole("member")
                    ->setStart($date)
                    ->setImprovisator($improvisator);
                 
                 $troupe->addMembership($m);
                 $em->persist($m);
             }
             
                 //dd($improvisators);
            //$troupe->setName($troupeform->getData()->getName());
            //$troupe->setDescription($troupeform->getData()->getDescription());
            //$troupe->setShortName($troupeform->getData()->getShortName());
            //$troupe->setLocation($troupeform->getData()->getLocation());
            $em->persist($troupe);
            $em->flush();
            
            
            $this->addFlash('success', 'Troupe has been updated!');
            

        }else{
            //$troupeform->setData($troupe);
        }
        
        return $this->render('troupe/troupe_edit.html.twig', [
            'troupe' =>$troupe,
            'troupeform'=>$troupeform->createView(),
            'improvisators' => $improvisators
        ]);
    }
}
