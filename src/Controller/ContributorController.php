<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Troupe;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\Voter\ContributorVoter;
use Symfony\Component\HttpFoundation\Request;
use ErrorException;
use App\Form\ContributorEditFormType;
use App\Form\ContributorManageEditorsFormType;
use App\Entity\Contributor;
use App\Entity\Improvisator;
use App\Entity\Team;

class ContributorController extends AbstractController
{
    
    
    private function getClassFromContributorType($contributor_type){
        
        switch ($contributor_type){
            case Contributor::TYPE_TROUPE :
                return Troupe::class;
                
            case Contributor::TYPE_TEAM:
                return Team::class;
                
            case Contributor::TYPE_IMPROVISATOR:
                return Improvisator::class;
                
            default:
                throw new ErrorException("code should not go here");
        }
    }
    
    
    
    
    
    
    /**
     * @Route("/{contributor_type}", name="contributor_list",
     *      requirements={"contributor_type":"troupe|team|improvisator"}
     * )
     */
    public function listTroupes(EntityManagerInterface $em, $contributor_type)
    {
        
        $contributorClass = $this->getClassFromContributorType($contributor_type);
        $repository = $em->getRepository($contributorClass);
        
        /** @var Contributor[] $contributors */
        $contributors = $repository->findAll();
        
        $parameters = array(
            'contributors' => $contributors,
            'contributor_type' => $contributor_type
        );
        
        return $this->render('contributor_abstract/contributor_list.html.twig', $parameters);
    }
    
    
    
    /**
     * @Route("/{contributor_type}/{identifier}", 
     *      name="contributor_identifier",
     *      requirements={"contributor_type":"troupe|team|improvisator"}
     * )
     */
    public function troupeByShortName($identifier, EntityManagerInterface $em, $contributor_type)
    {
        $contributorClass = $this->getClassFromContributorType($contributor_type);
        $repository = $em->getRepository($contributorClass);
        
        $contributor = $repository->findOneBy(array("identifier" =>$identifier));
        
        return $this->render('contributor_abstract/contributor.html.twig', [
            'contributor' =>$contributor,
        ]);
    }
    
    
    
    
    /**
     * @Route("/new/{contributor_type}",
     *      name="contributor_create",
     *      requirements={"contributor_type":"troupe|team|improvisator"}
     *      )
     */
    public function contributorCreate(EntityManagerInterface $em, Request $request, $contributor_type)
    {
        $contributorClass = $this->getClassFromContributorType($contributor_type);
        

        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        
        $repository = $em->getRepository($contributorClass);
        $form = $this->createForm(ContributorEditFormType::class,null,array("data_class"=>$contributorClass));
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var Contributor $contributor */
            $contributor=$form->getData();
            $contributor ->setCreatedBy($this->getUser())
                    ->addAdmin($this->getUser())
                    ->addSuperAdmin($this->getUser());
            
            
            $em->persist($contributor);
            $em->flush();
            
            $this->addFlash('success', 'Cool, a new '.$contributor->getType().' has been created!');  
            
            return $this->redirectToRoute('contributor_identifier',array('identifier'=>$contributor->getIdentifier(), 'contributor_type'=>$contributor->getType()));
            
        }
        return $this->render('contributor_abstract/contributor_new.html.twig', [
            'contributor_type'=> $contributor_type,
            'form'=>$form->createView()
        ]);
    }
    
    
    
    
    /**
     * @Route("/{contributor_type}/{identifier}/edit", 
     *      name="contributor_identifier_edit",
     *      requirements={"contributor_type":"troupe|team|improvisator"}
     *      )
     */
    public function ContributorEditByShortName($identifier, EntityManagerInterface $em, Request $request, $contributor_type)
    {
        $contributorClass = $this->getClassFromContributorType($contributor_type);
        
        $repository = $em->getRepository($contributorClass);
        
        $contributor = $repository->findOneBy(array("identifier" =>$identifier));

        $this->denyAccessUnlessGranted(ContributorVoter::EDIT_CONTRIBUTOR, $contributor);
        
        
        $form = $this->createForm(ContributorEditFormType::class,null,array("data_class"=>$contributorClass));
        $form->setData($contributor);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var Contributor $contributor */
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
    
    

    
    
    /**
     * @Route("/{contributor_type}/{identifier}/manage_editors", 
     *      name="contributor_identifier_manage_editors",
     *      requirements={"contributor_type":"troupe|team|improvisator"}
     *      )
     */
    public function troupeManagerEditorsByShortName($identifier, EntityManagerInterface $em, Request $request, $contributor_type)
    {
        $contributorClass = $this->getClassFromContributorType($contributor_type);
        $repository = $em->getRepository($contributorClass);
        
        $contributor = $repository->findOneBy(array("identifier" =>$identifier));
        
        $this->denyAccessUnlessGranted(ContributorVoter::MANAGE_USER_AS_EDITOR, $contributor);
        
        
     
        $form = $this->createForm(ContributorManageEditorsFormType::class,null,array("data_class"=>$contributorClass));
        $form->setData($contributor);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            /**  @var Contributor $contributor  */
            $contributor=$form->getData();
            

            $em->persist($contributor);
            $em->flush();
            
            
            $this->addFlash('success', 'Cool, the '.$contributor->getType().'\'s editors have been updated!');
            return $this->redirectToRoute('contributor_identifier',array('identifier'=>$contributor->getIdentifier(), 'contributor_type'=>$contributor->getType()));
            
            
        }
        
        return $this->render('contributor_abstract/contributor_edit.html.twig', [
            'contributor' =>$contributor,
            'form'=>$form->createView(),
        ]);
    }
    
    
}
