<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
$user=new User();
$user->setFio('Aleksandr Tihonyuk');
$user->setEmail('tihonyuk1999@gmail.com');
$user->setPassword('asdasdasd');
$user->setBirthdaydate('1999-10-22');
$user->setPhoneNum('992445148');
$user->setSex("male");
$manager->persist($user);

        $user=new User();
        $user->setFio('Alice Vasilieva');
        $user->setEmail('alice@gmail.com');
        $user->setPassword('asdasdasd');
        $user->setBirthdaydate('2001-08-08');
        $user->setPhoneNum('992445148');
        $user->setSex("female");
        $manager->persist($user);


$manager->flush();
    }
}
