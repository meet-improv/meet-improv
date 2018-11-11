<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends BaseFixture
{
    
    private $passwordEncoder;
    
        public function __construct(UserPasswordEncoderInterface $passwordEncoder)
        {
            $this->passwordEncoder = $passwordEncoder;
     
        }
    public function loadData(ObjectManager $manager)
    {
        
        $this->createMany(User::class, 10, function(User $user,$i) {
            
            $user->setUsername($this->faker->userName)
            ->setPassword($this->passwordEncoder->encodePassword($user,'1234'));
            
            return $user;
        });
        
        $user = new User();
        $user->setUsername("yannloup")
        ->setPassword($this->passwordEncoder->encodePassword($user,'1234'));
        
        $manager->persist($user);
        
        $this->addReference("user", $user);
      
        $manager->flush();
    }
}
