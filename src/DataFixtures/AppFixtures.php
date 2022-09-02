<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Hall;
use App\Entity\Leader;
use App\Entity\Permission;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        //Users
        $users = [];
        for($a=0; $a < 5; $a++){
            $user= new User();
            $user->setFirstname($faker->lastName)
                ->setName($faker->lastName)
                ->setEmail($faker->email)
                ->setRoles(['ROLE_USER'])
                ->setPassword('');
            $users[] = $user;
            $manager->persist($user);
        }

        // Halls
         /*$halls =[];
         for ($j=0; $j <15; $j++){

             $hall = new Hall();

             $hall->setName($faker->lastName);
             $hall->setStreetNumber($faker->numberBetween($min = 1, $max = 200));
             $hall->setAdress($faker->address);
             $hall->setCity($faker->city);
             $hall->setIsactive(rand(0,1));
             $hall->setPhone($faker->e164PhoneNumber);
             $hall->setPostalCode($faker->postcode);
             $hall->setShortDescription($faker->sentence($nbWords = 15, $variableNbWords = true));
                 //->setUser($users[mt_rand(0, count($users)-1)]);

             $halls[] = $hall;

             $manager->persist($hall);
         }*/

        //leader
        $leaders = [];
        for ($u=0; $u < 10; $u++){
            $leader = new Leader();

            $leader->setName($faker->lastName)
                ->setFirstname($faker->lastName)
                ->setCity($faker->city)
                ->setMail($faker->email)
                ->setPhone($faker->e164PhoneNumber)
                ->setCommercialPhone($faker->e164PhoneNumber)
                ->setIsActive(rand(0,1));

                $leaders[] = $leader;

            $manager->persist($leader);
        }



        // Permissions
        /*for ($i=0; $i <10; $i++){
            $permission = new Permission();

            $permission->setIsMembersAdd(rand(0,1));
            $permission->setIsMembersRead(rand(0,1));
            $permission->setIsMembersStatistiqueRead(rand(0,1));
            $permission->setIsMembersWrite(rand(0,1));
            $permission->setIsPaymentSchedulesAdd(rand(0,1));
            $permission->setIsSellDrinks(rand(0,1));
            $permission->setIsPaymentSchedulesWrite(rand(0,1));


            $manager->persist($permission);


        }*/

        for ($i=0; $i<5; $i++){
            $contact= new Contact;

            $contact->setEmail($faker->email)
                ->setName($faker->lastName)
                ->setMessage($faker->sentence($nbWords = 15, $variableNbWords = true))
                ->setSubject($faker->sentence($nbWords = 2, $variableNbWords = true));


            $manager->persist($contact);

        }

        $manager->flush();
    }
}
