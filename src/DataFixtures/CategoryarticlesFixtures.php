<?php

namespace App\DataFixtures;

use App\Entity\Categoryarticles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryarticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $Categoryarticles = new Categoryarticles();
        $Categoryarticles->setName('Thermorientalix');
        $manager->persist($Categoryarticles);

        $Categoryarticles2 = new Categoryarticles();
        $Categoryarticles2->setName('Thermorientalix');
        $manager->persist($Categoryarticles2);



        $manager->flush();

        $this->addReference(name: 'categoryarticles_1', object: $Categoryarticles);
        $this->addReference(name: 'categoryarticles_2', object: $Categoryarticles2);



    }
}
