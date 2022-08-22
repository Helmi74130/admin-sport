<?php

namespace App\DataFixtures;

use App\Entity\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        for ($i=0; $i <=49; $i++){
            $permission = new Permission();
            $permission->setIsMembersAdd(rand(0,1));
            $permission->setIsMembersRead(rand(0,1));
            $permission->setIsMembersStatistiqueRead(rand(0,1));
            $permission->setIsMembersWrite(rand(0,1));
            $permission->setIsPaymentSchedulesAdd(rand(0,1));
            $permission->setIsSellDrinks(rand(0,1));
            $permission->setIsPaymentSchedulesWrite(rand(0,1));

            $manager->persist($permission);
        }

        $manager->flush();
    }
}
