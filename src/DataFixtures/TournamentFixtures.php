<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tournament;
use App\Service\Tournament\SlugService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TournamentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $tournament = new Tournament();
            $tournament->setName('Tournament '.$i);
            $tournament->setSlug(SlugService::createSlug($tournament->getName()));
            $manager->persist($tournament);
        }

        $manager->flush();
    }
}