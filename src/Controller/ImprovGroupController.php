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
use App\Entity\Membership;
use App\Form\ContributorManageEditorsFormType;
use App\Entity\Contributor;
use App\Entity\Improvisator;
use App\Entity\Team;
use App\Entity\ImprovGroup;
use App\Form\ImprovGroupAddMembersFormType;

class ImprovGroupController extends AbstractController
{
    
    
    private function getClassFromContributorType($contributor_type){
        
        switch ($contributor_type){
            case Contributor::TYPE_TROUPE :
                return Troupe::class;
                
            case Contributor::TYPE_TEAM:
                return Team::class;
            default:
                throw new ErrorException("code should not go here");
        }
    }

    

    /**
     * @Route("/{contributor_type}/{identifier}/manage_members", 
     *      name="improvGroup_identifier_manage_members",
     *      requirements={"contributor_type":"troupe|team"}
     *      )
     */
    public function improvGroupManagerMembersByShortName($identifier, EntityManagerInterface $em, Request $request, $contributor_type)
    {
        $contributorClass = $this->getClassFromContributorType($contributor_type);
        $repository = $em->getRepository($contributorClass);
        
        $improvGroup = $repository->findOneBy(array("identifier" =>$identifier));
        
        $this->denyAccessUnlessGranted(ContributorVoter::EDIT_CONTRIBUTOR, $improvGroup);
        
        
        $form = $this->createForm(ImprovGroupAddMembersFormType::class,null,array("data_class"=>$contributorClass));
        $form->setData($improvGroup);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            
            /** @var ImprovGroup $improvGroup */
            $improvGroup=$form->getData();
            
            $improvisators = $form->getRoot()->get("improvisators")->getData();
            
            $date = new \DateTime("now");
            
            /** @var Improvisator $improvisator  */
            foreach ($improvisators as $improvisator){
                // dd($improvisator);
                
                $m = new Membership();
                
                $m->setImprovGroup($improvGroup)
                ->setIsHidden(false)
                ->setRole("member")
                ->setStart($date)
                ->setImprovisator($improvisator);
                
                $improvGroup->addMembership($m);
                $em->persist($m);
            }
            
            $em->persist($improvGroup);
            $em->flush();
            
            
            $this->addFlash('success', 'Members have been added to '.$improvGroup->getType().'!');
            
            return $this->redirectToRoute('contributor_identifier',array('identifier'=>$improvGroup->getIdentifier(), 'contributor_type'=>$improvGroup->getType()));
            
            
        }
        
        return $this->render('contributor_abstract/contributor_edit.html.twig', [
            'contributor' =>$improvGroup,
            'form'=>$form->createView(),
            
        ]);
    }
    
    
}
