<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Publication;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var \Faker\Factory
     */
    private $faker;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker=\Faker\Factory::create();
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadPublication($manager);
        $this->loadComment($manager);
    }


    public function loadUsers(ObjectManager $manager)
    {
        $user=new User();
        $user->setFio('Aleksandr Tihonyuk');
        $user->setEmail('tihonyuk1999@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'asdasdasd'));
        $user->setBirthdaydate('1999-10-22');
        $user->setPhoneNum('992445148');
        $user->setSex("male");

        $this->addReference('Alex',$user);

        $manager->persist($user);

        /*$user=new User();
        $user->setFio('Alice Vasilieva');
        $user->setEmail('alice@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'sadasdcxz'));
        $user->setBirthdaydate('2001-08-08');
        $user->setPhoneNum('992445148');
        $user->setSex("female");
        $manager->persist($user);*/


        $manager->flush();
    }

    public function loadPublication(ObjectManager $manager)
    {
        $user=$this->getReference('Alex');
        for($i=0;$i<10;$i++)
        {
            $pub=new Publication();
            $pub->setContent($this->faker->realText(15));
            $pub->setDateOfPub($this->faker->dateTimeThisYear);
            $pub->setUser($user);
            $pub->setFoto($this->faker->realText(20));

            $this->setReference("publication_$i",$pub);

            $manager->persist($pub);
        }
        $manager->flush();
    }
    public function loadComment(ObjectManager $manager)
    {
        for($i=0;$i<10;$i++)
        {
            for($j=0;$j<rand(1,6);$j++)
            {
                $comment= new Comment();
                $comment->setUser($this->getReference('Alex'));
                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear());
                $comment->setPublication($this->getReference("publication_$i"));

                $manager->persist($comment);
            }
        }
        $manager->flush();
    }
}
