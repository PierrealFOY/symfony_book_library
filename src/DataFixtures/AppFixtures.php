<?php

namespace App\DataFixtures;

// use App\DataFixtures\Providers\AppProvider;
use App\Entity\Book;
use App\Entity\Author;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    
        $faker = Faker\Factory::create("fr_FR");

        $authors = [];
        for ($i = 0; $i < 4; $i++) {
            $authors[$i] = new Author();
            $authors[$i]->setName($faker->lastName);
            $authors[$i]->setFirstname($faker->firstName);

            $manager->persist($authors[$i]);
        }

        $books = [];
        for ($i = 0; $i < 12; $i++) {
            $books[$i] = new Book();
            $books[$i]->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $books[$i]->setAuthor($faker->lastName);
            $books[$i]->setGenre($faker->randomElement($array = array ('Roman', 'Policier', 'Science-fiction', 'Fantastique', 'Biographie', 'Histoire', 'Théâtre', 'Poésie', 'Essai', 'Journalisme', 'Bandes dessinées', 'Manga', 'Comics', 'Autobiographie', 'Autres')));

            $manager->persist($books[$i]);
            $books[$i]->setReleaseDate($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null));
            $books[$i]->setPoster($faker->imageUrl($width = 640, $height = 480, 'cats', true, 'Faker', true));
        }        
        
        $manager->flush();
    }
}
