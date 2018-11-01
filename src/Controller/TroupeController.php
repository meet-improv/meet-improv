<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Troupe;
use Doctrine\ORM\EntityManagerInterface;

class TroupeController extends AbstractController
{
    /**
     * @Route("/troupe", name="troupe")
     */
    public function index(EntityManagerInterface $em)
    {
        
        
        $repository = $em->getRepository(Troupe::class);
        
        /** @var Troupe[] $troupes */
        $troupes = $repository->findAll();
        
        $parameters = array(
            'troupes' => $troupes);
        
        return $this->render('troupe/index.html.twig', $parameters);
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
     * @Route("/troupe/{shortName}", name="troupe_shortName")
     */
    public function troupeByShortName($shortName, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Troupe::class);
        
        $troupe = $repository->findOneBy(array("shortName" =>$shortName));
        
        return $this->render('troupe/troupe.html.twig', [
            'troupe' =>$troupe,
        ]);
    }
}
