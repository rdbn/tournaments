<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 6; $i++) {
            $team = new Team();
            $team->setName('Team '.$i);
            $manager->persist($team);
        }

        $manager->flush();
    }
}