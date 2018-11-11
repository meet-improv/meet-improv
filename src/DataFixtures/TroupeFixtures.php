<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Troupe;
use App\Entity\Improvisator;
use App\Entity\Membership;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TroupeFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $group = new Troupe();
        $group->setName("Association d'Improvisation Antiboise")
        ->setShortName("AIA")
        ->setDescription("L’AIA a été créée en février 2004 par une quinzaine de comédiens issus de diverses compagnies théâtrales.")
        ->setLocation("Antibes, FR")
        ->setCreatedBy($this->getReference("user"))
        ->addSuperAdmin($this->getReference("user"))
        ->addAdmin($this->getReference("user"));
        
        $this->addReference("aia", $group);
        
        $manager->persist($group);
        
        $group1 = new Troupe();
        $group1->setName("Ligue d'Improvisation de la Côte d'Azur")
        ->setShortName("LICA")
        ->setDescription("La LICA est toute jeune")
        ->setLocation("Cannes, FR")
        ->setCreatedBy($this->getReference("user"))
        ->addSuperAdmin($this->getReference("user"))
        ->addAdmin($this->getReference("user"));
        
        $manager->persist($group1);
        
        $group2 = new Troupe();
        $group2->setName("Counta Blablas")
        ->setShortName("Countas")
        ->setDescription("On est niçois")
        ->setLocation("Nice, FR")
        ->setCreatedBy($this->getReference("user"))
        ->addSuperAdmin($this->getReference("user"))
        ->addAdmin($this->getReference("user"));
        
        $manager->persist($group2);
        
        
        $this->createMany(Troupe::class, 20, function(Troupe $troupe,$i) {
            
            $user = $this->getRandomReference(User::class);
            
            $name= $this->faker->company;
            $troupe->setName($name)
            ->setShortName($name)
            ->setDescription($this->faker->sentence())
            ->setLocation($this->faker->city)
            ->setCreatedBy($user)
            ->addSuperAdmin($user)
            ->addAdmin($user);
            
            return $troupe;
        });
     
      

        $manager->flush();
    }
    
    public function getDependencies()
    
    {
        return [UserFixtures::class];
    }
}
