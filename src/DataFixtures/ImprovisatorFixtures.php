<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Improvisator;
use App\Entity\User;
use App\Entity\Membership;
use App\Entity\Troupe;

class ImprovisatorFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $improvisator1= new Improvisator();
        $improvisator1->setName("Priscilla Beyrand")
        ->setShortName("Priscilla")
        ->setDescription("Priscilla Beyrand une comédienne fantaisiste professionelle. ")
        ->setCreatedBy($this->getReference("user"))
        ->addSuperAdmin($this->getReference("user"))
        ->addAdmin($this->getReference("user"));
        
        $manager->persist($improvisator1);
        
        
        $membership = new Membership();
        $date = new \DateTime("01-03-2014");
        $membership->setImprovGroup($this->getReference("aia"))
        ->setImprovisator($improvisator1)
        ->setRole("Présidente")
        ->setStart($date)
        ->setIsHidden(false);
        
        
        $manager->persist($membership);
        
        $this->createMany(Improvisator::class, 40, function(Improvisator $improvisator,$i) {
            
            $user = $this->getRandomReference(User::class);
            
            $improvisator->setName($this->faker->firstName." ". $this->faker->lastName)
            ->setShortName($this->faker->firstName)
            ->setDescription($this->faker->sentence())
            ->setCreatedBy($user)
            ->addSuperAdmin($user)
            ->addAdmin($user);
            
            return $improvisator;
        });
        
            $this->createMany(Membership::class, 200, function(Membership $membership,$i) {
                
                
                
                $membership->setImprovGroup($this->getRandomReference(Troupe::class))
                ->setImprovisator($this->getRandomReference(Improvisator::class))
                ->setRole($this->faker->jobTitle)
                ->setStart($this->faker->dateTime)
                ->setIsHidden(false);
                
                return $membership;
            });
        

        $manager->flush();
    }
    
    
    public function getDependencies()
    
    {
        return [UserFixtures::class, TroupeFixtures::class];
    }
    
}
