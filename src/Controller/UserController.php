<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function listUsers(EntityManagerInterface $em)
    {
        
        
        $repository = $em->getRepository(User::class);
        
        /** @var User[] $troupes */
        $users = $repository->findAll();
        
        $parameters = array(
            'users' => $users);
        
        return $this->render('user/list_users.html.twig', $parameters);
        
    }
    
    
    /**
     * @Route("/user/{username}", name="user_profile")
     */
    public function profile(EntityManagerInterface $em,$username)
    {
        
        
        $repository = $em->getRepository(User::class);
        
        $user = $repository->findOneBy(array("username" =>$username));
        
        $parameters = array(
            'user' => $user);
        
        return $this->render('user/profile.html.twig', $parameters);
        
    }
}
