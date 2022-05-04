<?php

namespace App\DataFixtures;

use App\Entity\Cards;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CardsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        for($i = 1; $i < 11; $i ++){

            $card = new Cards();
            $card
            ->setName("Carte n° $i")
            ->setValue(rand(20,200))
            ->setQuantite(1)
            ->setImage($i . '.png')
            ->setDescription("Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. 
            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.")
            ->setBuyAt(new \DateTimeImmutable())
            ->setSellAt(new \DateTimeImmutable())
            ->setInSell(true);
            
            
          
            $manager->persist($card);
        }
        $manager->flush();
    }
}
