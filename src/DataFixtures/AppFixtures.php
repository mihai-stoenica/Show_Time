<?php

namespace App\DataFixtures;

use App\Entity\Band;
use App\Enum\MusicGenre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $bands = [
            ['name' => 'The Rolling Stones', 'genre' => MusicGenre::Rock],
            ['name' => 'Daft Punk', 'genre' => MusicGenre::Electronic],
            ['name' => 'BTS', 'genre' => MusicGenre::KPop],
            ['name' => 'Metallica', 'genre' => MusicGenre::Metal],
            ['name' => 'Adele', 'genre' => MusicGenre::Soul],
            ['name' => 'Coldplay', 'genre' => MusicGenre::Alternative],
            ['name' => 'Eminem', 'genre' => MusicGenre::Rap],
            ['name' => 'Miles Davis Quintet', 'genre' => MusicGenre::Jazz],
            ['name' => 'The Beatles', 'genre' => MusicGenre::Pop],
            ['name' => 'Green Day', 'genre' => MusicGenre::Punk],
            ['name' => 'Imagine Dragons', 'genre' => MusicGenre::Indie],
            ['name' => 'The Weeknd', 'genre' => MusicGenre::RnB],
            ['name' => 'Bon Iver', 'genre' => MusicGenre::Folk],
            ['name' => 'Skrillex', 'genre' => MusicGenre::Dubstep],
            ['name' => 'Nirvana', 'genre' => MusicGenre::Grunge],
            ['name' => 'Linkin Park', 'genre' => MusicGenre::Hardcore],
            ['name' => 'Radiohead', 'genre' => MusicGenre::Alternative],
            ['name' => 'Arctic Monkeys', 'genre' => MusicGenre::Indie],
            ['name' => 'Beethoven Ensemble', 'genre' => MusicGenre::Classical],
            ['name' => 'Florence + The Machine', 'genre' => MusicGenre::Soul],
            ['name' => 'Deadmau5', 'genre' => MusicGenre::House],
            ['name' => 'Bob Marley & The Wailers', 'genre' => MusicGenre::Reggae],
            ['name' => 'Gorillaz', 'genre' => MusicGenre::Electronic],
            ['name' => 'Ludwig Göransson Orchestra', 'genre' => MusicGenre::Soundtrack],
        ];

        foreach ($bands as $data) {
            $band = new Band();
            $band->setName($data['name']);
            $band->setGenre($data['genre']);
            $manager->persist($band);
        }

        $manager->flush();
    }
}
