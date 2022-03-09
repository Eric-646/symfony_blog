<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->passwordHasher = $userPasswordHasherInterface;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $toto = new User();
        $toto->setEmail("toto@toto.fr");
        $toto->setDateCreation($faker->dateTimeBetween('-6 months'));
        $toto->setPseudo("toto");
        // $toto->setRoles();
        $hash = $this->passwordHasher->hashPassword($toto, "toto");
        $toto->setPassword($hash);
        $manager->persist($toto);

        for ($h = 0; $h < 5; $h++) {

            $user = new User();
            $user->setEmail($faker->email());
            $user->setDateCreation($faker->dateTimeBetween('-6 months'));
            $user->setPseudo($faker->name());
            $hash = $this->passwordHasher->hashPassword($user, "toto");
            $user->setPassword($hash);

            $manager->persist($user);





            // $tata = new User();
            // $tata->setEmail("tata@tata.fr");
            // $tata->setDateCreation(new \DateTime());
            // $tata->setPseudo("tata");
            // $hash = $this->passwordHasher->hashPassword($tata, "tata");
            // $tata->setPassword($hash);
            // $manager->persist($tata);









            for ($i = 1; $i <= 3; $i++) {

                $cat = new Categorie();
                // $cat->setNom($faker->sentence( 2, true));
                $cat->setNom($faker->word($faker->numberBetween(1, 3)));
                //    dd($faker->sentence()) ;

                $manager->persist($cat);

                for ($j = 1; $j <= 5; $j++) {
                    // ($faker->numberBetween(10, 20))
                    $article = new Article();
                    $article->setTitre($faker->word($faker->numberBetween(1, 5)));
                    // $article->setTitre($faker->sentence($nbWords = 2, $variableNbWords = true));
                    $article->setContenu($faker->realText);
                    $article->setDatePublication($faker->dateTimeBetween('-6 months'));
                    $article->setImageSrc("https://picsum.photos/250/80");
                    $article->setNombreVues(0);
                    $article->setCategorie($cat);
                    // $article->setUser($toto);
                    $article->setUser($user);

                    $manager->persist($article);

                    for ($k = 1; $k <= 2; $k++) {

                        $commentaire = new Commentaire();
                        $commentaire->setDate($faker->dateTimeBetween('-6 months'));
                        $commentaire->setContenu($faker->realText($faker->numberBetween(10, 20)));
                        $commentaire->setPublie(false);
                        $commentaire->setArticle($article);
                        // $commentaire->setUser($tata);
                        $commentaire->setUser($user);

                        $manager->persist($commentaire);
                    }
                }
            }
        }



        $manager->flush();
    }
}
