<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Hall;
use App\Entity\Leader;
use App\Entity\LeaderHall;
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




        /*for ($j=0; $j <10; $j++){

            for($a=0; $a <= 2; $a++){
                $user= new User();
                $user->setFirstname($faker->lastName)
                    ->setName($faker->lastName)
                    ->setEmail($faker->email)
                    ->setRoles(['ROLE_USER'])
                    ->setPhone('0174545415')
                    ->setCivility('Mr')
                    ->setCity($faker->city)
                    ->setIsActive(rand(0,1))
                    ->setPassword('123');

                $manager->persist($user);
            }

            $leader = new Leader();
                //Leader
                $leader->setName($faker->lastName)
                    ->setFirstname($faker->lastName)
                    ->setCity($faker->city)
                    ->setCivility('Mr')
                    ->setEmail($faker->email)
                    ->setPhone($faker->e164PhoneNumber)
                    ->setUser($user)
                    ->setIsActive(rand(0,1));

                $manager->persist($leader);


            $leaderHall =new LeaderHall();

            $leaderHall->setName($faker->lastName)
                ->setFirstname($faker->lastName)
                ->setCivility('Mr')
                ->setCity($faker->city)
                ->setEmail($faker->email)
                ->setPhone($faker->e164PhoneNumber)
                ->setIsActive(rand(0,1))
                ->setUser($user);

                // Halls
                $hall = new Hall();

                $hall->setName($faker->lastName)
                    ->setStreetNumber($faker->numberBetween($min = 1, $max = 200))
                    ->setAdress($faker->address)
                    ->setCity($faker->city)
                    ->setIsactive(rand(0,1))
                    ->setPhone($faker->e164PhoneNumber)
                    ->setPostalCode($faker->postcode)
                    ->setShortDescription($faker->sentence($nbWords = 15, $variableNbWords = true))
                    ->setLeaderHall($leaderHall)
                    ->setLeader($leader);

                $manager->persist($hall);

                    // Permissions
                    $permission = new Permission();

                    $permission->setIsMembersAdd(rand(0,1))
                        ->setIsMembersRead(rand(0,1))
                        ->setIsMembersStatistiqueRead(rand(0,1))
                        ->setIsMembersWrite(rand(0,1))
                        ->setIsPaymentSchedulesAdd(rand(0,1))
                        ->setIsSellDrinks(rand(0,1))
                        ->setIsPaymentSchedulesWrite(rand(0,1))
                        ->setHall($hall);

                    $manager->persist($permission);
        }*/

       /* for ($i=0; $i<5; $i++){
            $contact= new Contact;

            $contact->setEmail($faker->email)
                ->setName($faker->lastName)
                ->setMessage($faker->sentence($nbWords = 15, $variableNbWords = true))
                ->setSubject($faker->sentence($nbWords = 2, $variableNbWords = true));


            $manager->persist($contact);

        }*/

        $manager->flush();
    }
}
