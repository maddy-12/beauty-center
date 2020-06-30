<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture

{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();
        $categories = [];

        for ($i = 0; $i < 5; $i++) {

            $oneCategory = new Category();
            $oneCategory->setName($faker->word());
            $manager->persist($oneCategory);
            $categories[] = $oneCategory;
        }
        for ($i = 0; $i < 10; $i++) {
            $oneUser = new User();
            $oneUser->setNickname($faker->word());
            $oneUser->setPassword($this->passwordEncoder->encodePassword($oneUser, "mdp"));
            $oneUser->setEmail($faker->email());
            $manager->persist($oneUser);

            for ($j = 0; $j < 10; $j++) {
                $oneArticle = new Article();
                $oneArticle->setTitle($faker->word());
                $oneArticle->setContent($faker->text(255));
                $oneArticle->setUrlImg($faker->imageUrl(300, 600));
                $oneArticle->setUser($oneUser);
                for ($l = 0; $l < mt_rand(1, 3); $l++) {
                    $oneArticle->addCategory($categories[mt_rand(0, count($categories) - 1)]);
                }

                $manager->persist($oneArticle);
            }
        }

        $manager->flush();
    }
}
