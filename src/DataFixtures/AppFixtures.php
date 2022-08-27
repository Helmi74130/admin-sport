<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use App\Entity\Leader;
use App\Entity\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        /*// Permissions
        $permissions = [];
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
        $halls =[];
        for ($j=0; $j <10; $j++){

            $hall = new Hall();

            $hall->setName($faker->lastName);
            $hall->setStreetNumber($faker->numberBetween($min = 1, $max = 200));
            $hall->setAdress($faker->address);
            $hall->setCity($faker->city);
            $hall->setIsactive(rand(0,1));
            $hall->setPhone($faker->e164PhoneNumber);
            $hall->setPostalCode($faker->postcode);
            $hall->setShortDescription($faker->sentence($nbWords = 15, $variableNbWords = true));

            $halls[] = $hall;

            /*for($i = 0; $i < mt_rand(1,5) ; $i++){
                $hall->setPermissions($permissions[mt_rand(0, count($permissions) - 1)]);
            }*/
            $manager->persist($hall);
        }
        //leader
        for ($u=0; $u < 15; $u++){
            $leader = new Leader();

            $leader->setName($faker->lastName)
                ->setFirstname($faker->lastName)
                ->setCity($faker->city)
                ->setMail($faker->email)
                ->setPhone($faker->e164PhoneNumber)
                ->setCommercialPhone($faker->e164PhoneNumber)
                ->setIsActive(rand(0,1));

                for($k = 0; $k < mt_rand(1,15); $k++){
                    $leader->addHall($halls[mt_rand(0, count($halls) - 1)]);
                }


                $manager->persist($leader);
        }







        $manager->flush();
    }
}
