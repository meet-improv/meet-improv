<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Troupe;
use App\Entity\Improvisator;
use App\Entity\Membership;

class TroupeFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $group = new Troupe();
        $group->setName("Association d'Improvisation Antiboise")
        ->setShortName("AIA")
        ->setDescription("AIA est basée à Antibes Yeah")
        ->setLocation("Antibes, FR");
        
        $manager->persist($group);
        
        $group1 = new Troupe();
        $group1->setName("Ligue d'Improvisation de la Côte d'Azur")
        ->setShortName("LICA")
        ->setDescription("La LICA est toute jeune")
        ->setLocation("Cannes, FR");
        
        $manager->persist($group1);
        
        $group2 = new Troupe();
        $group2->setName("Counta Blablas")
        ->setShortName("Countas")
        ->setDescription("On est niçois")
        ->setLocation("Nice, FR");
        
        $manager->persist($group2);
        
        
        $improvisator1= new Improvisator();
        $improvisator1->setName("Priscilla Beyrand")
        ->setShortName("pripribey")
        ->setDescription("blabla");
        
        $manager->persist($improvisator1);
        
        $membership = new Membership();
        $date = new \DateTime("01-03-2014");
        $membership->setImprovGroup($group)
        ->setImprovisator($improvisator1)
        ->setRole("Présidente")
        ->setStart($date)
        ->setIsHidden(false);
      
        
        $manager->persist($membership);

        $manager->flush();
    }
}
