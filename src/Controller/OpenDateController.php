<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OpenDateRepository;
use App\Form\OpenDateCreateFormType;
use App\Entity\OpenDate;

class OpenDateController extends AbstractController
{
    /**
     * @Route("/opendate/{identifier}", name="opendate_identifier")
     */
    public function index($identifier,EntityManagerInterface $em)
    {
        $repository = $em->getRepository(OpenDate::class);
        
        $opendate = $repository->findOneBy(array("identifier"=>$identifier));
        
        if (!$opendate) {
            throw $this->createNotFoundException(sprintf('No opendate for "%s"', $identifier));
        }
        
        
        return $this->render('opendate/opendate_index.html.twig', [
            "opendate"=> $opendate
        ]);
    }
    
    
    /**
     * @Route("new/opendate", name="open_date_creation")
     */
    public function newOpenDate(EntityManagerInterface $em, Request $request)
        {
            $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
            
            $repository = $em->getRepository(OpenDate::class);
            $form = $this->createForm(OpenDateCreateFormType::class);//,null, array("user"=>$this->getUser()));
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                /** @var OpenDate $opendate */
                $opendate=$form->getData();
                $opendate ->setCreatedBy($this->getUser());
                
                
                $em->persist($opendate);
                $em->flush();
                
                $this->addFlash('success', 'Cool, a new open date has been created for '.$opendate->getOwner()->getName().'!');
                
                return $this->redirectToRoute('opendate_identifier',array('identifier'=>$opendate->getIdentifier()));
                
            }
        
        
        return $this->render('opendate/opendate_new.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
