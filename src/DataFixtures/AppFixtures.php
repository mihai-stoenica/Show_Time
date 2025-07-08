<?php

namespace App\DataFixtures;

use App\Entity\Band;
use App\Entity\Festival;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $festivalData = [
            ['name' => 'Sunblast Festival', 'location' => 'Barcelona'],
            ['name' => 'Echo Valley', 'location' => 'Prague'],
            ['name' => 'Nightwave', 'location' => 'Berlin'],
            ['name' => 'Meadow Rave', 'location' => 'Amsterdam'],
            ['name' => 'Skyline Sounds', 'location' => 'Paris'],
            ['name' => 'Aurora Beats', 'location' => 'Oslo'],
            ['name' => 'Firelight Fest', 'location' => 'Budapest'],
            ['name' => 'River Rhythms', 'location' => 'Vienna'],
            ['name' => 'Crystal Vibes', 'location' => 'Zurich'],
            ['name' => 'Twilight Echoes', 'location' => 'Helsinki'],
            ['name' => 'Stormpulse', 'location' => 'Copenhagen'],
            ['name' => 'Bass Horizon', 'location' => 'Lisbon'],
            ['name' => 'Lunar Bloom', 'location' => 'Stockholm'],
            ['name' => 'Neon Grove', 'location' => 'Warsaw'],
            ['name' => 'Solar Sounds', 'location' => 'Munich'],
            ['name' => 'Echo Drift', 'location' => 'Reykjavik'],
            ['name' => 'Radiowave', 'location' => 'London'],
            ['name' => 'Nocturne Pulse', 'location' => 'Milan'],
            ['name' => 'Velvet Jam', 'location' => 'Brussels'],
            ['name' => 'Crescendo Field', 'location' => 'Athens'],
        ];

        foreach ($festivalData as $data) {
            $festival = new Festival();
            $festival->setName($data['name']);
            $festival->setLocation($data['location']);

            // Random start and end dates
            $startDate = new \DateTime('+' . random_int(1, 30) . ' days');
            $endDate = (clone $startDate)->modify('+' . random_int(1, 3) . ' days');
            $festival->setStartDate($startDate);
            $festival->setEndDate($endDate);

            // Random price between 20 and 100
            $festival->setPrice(mt_rand(2000, 10000) / 100);

            // Add 3 to 6 random bands with ID between 12 and 35
            $bandCount = random_int(3, 6);
            $bandIds = array_rand(array_flip(range(12, 35)), $bandCount);

            if (!is_array($bandIds)) {
                $bandIds = [$bandIds]; // Ensure it's always an array
            }

            foreach ($bandIds as $bandId) {
                // Use reference or load manually if not using BandFixtures
                $band = $manager->getRepository(Band::class)->find($bandId);
                if ($band) {
                    $festival->addBand($band);
                }
            }

            $manager->persist($festival);
        }

        $manager->flush();
    }
}
