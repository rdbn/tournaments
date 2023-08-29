<?php

declare(strict_types=1);

namespace App\Tests\Service\Tournament;

use App\Entity\Team;
use App\Service\Tournament\TeamTournamentGenerator;
use PHPUnit\Framework\TestCase;

class TeamTournamentGeneratorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGenerate(array $teams, array $expect): void
    {
        $teamTournamentGenerator = new TeamTournamentGenerator();
        $mesh = $teamTournamentGenerator->generate($teams);

        $this->assertEquals($expect, $mesh);
    }

    public static function dataProvider(): \Generator
    {
        $team1 = (new Team())->setName('team1');
        $team2 = (new Team())->setName('team2');
        $team3 = (new Team())->setName('team3');
        $team4 = (new Team())->setName('team4');
        $team5 = (new Team())->setName('team5');
        yield [
            'teams' => [$team1, $team2, $team3, $team4, $team5],
            'expect' => [
                [[$team2, $team5], [$team3, $team4]],
                [[$team1, $team2], [$team4, $team5]],
                [[$team1, $team3], [$team4, $team2]],
                [[$team1, $team4], [$team5, $team3]],
                [[$team1, $team5], [$team2, $team3]],
            ],
        ];

        $team6 = (new Team())->setName('team6');
        yield [
            'teams' => [$team1, $team2, $team3, $team4, $team5, $team6],
            'expect' => [
                [[$team1, $team6], [$team2, $team5], [$team3, $team4]],
                [[$team1, $team2], [$team3, $team6], [$team4, $team5]],
                [[$team1, $team3], [$team4, $team2], [$team5, $team6]],
                [[$team1, $team4], [$team5, $team3], [$team6, $team2]],
                [[$team1, $team5], [$team6, $team4], [$team2, $team3]],
            ],
        ];
    }
}