<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use App\Entity\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        // Permissions
       /* $permissions = [];
        for ($i=0; $i <=50; $i++){
            $permission = new Permission();

            $permission->setIsMembersAdd(rand(0,1));
            $permission->setIsMembersRead(rand(0,1));
            $permission->setIsMembersStatistiqueRead(rand(0,1));
            $permission->setIsMembersWrite(rand(0,1));
            $permission->setIsPaymentSchedulesAdd(rand(0,1));
            $permission->setIsSellDrinks(rand(0,1));
            $permission->setIsPaymentSchedulesWrite(rand(0,1));

            $permissions[] = $permission;

            $manager->persist($permission);
        }*/

        // Halls
        for ($j=0; $j <50; $j++){
            $hall = new Hall();

            $hall->setName($faker->lastName);
            $hall->setStreetNumber($faker->numberBetween($min = 1, $max = 200));
            $hall->setAdress($faker->address);
            $hall->setCity($faker->city);
            $hall->setIsactive(rand(0,1));
            $hall->setPhone($faker->e164PhoneNumber);
            $hall->setPostalCode($faker->postcode);
            $hall->setShortDescription($faker->sentence($nbWords = 15, $variableNbWords = true));

            /*for($k = 0; $k < mt_rand(1,2); $k++){
                $hall->addPermission($permissions[mt_rand(0, count($permissions) - 1)]);
            }*/
            $manager->persist($hall);
        }

        $manager->flush();
    }
}
