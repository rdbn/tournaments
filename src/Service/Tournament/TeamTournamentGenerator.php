<?php

declare(strict_types=1);

namespace App\Service\Tournament;

use App\Entity\Team;

class TeamTournamentGenerator
{
    private const MAX_MEET_DAY = 4;

    /**
     * @param Team[] $teams
     * @return array
     */
    public function generate(array $teams): array
    {
        $countTeams = count($teams);
        $countMatches = $countTeams * ($countTeams - 1) / 2;
        $countMatchInDay = $this->countMatchInDay($countTeams);
        if ($countTeams % 2 != 0) {
            $teams[] = null;
            $countTeams++;
        }
        $teamsMatches = [];

        while ((count($teamsMatches) / 2) != $countMatches) {
            for ($i = 0; $i < $this->countMatchInDay($countTeams); $i++) {
                if ($teams[$i] !== null && $teams[$countTeams - ($i + 1)] !== null) {
                    $teamsMatches[] = $teams[$i];
                    $teamsMatches[] = $teams[$countTeams - ($i + 1)];
                }
            }
            $firstTeam = array_shift($teams);
            $teams[] = array_shift($teams);
            array_unshift($teams, $firstTeam);
        }
        return array_chunk(array_chunk($teamsMatches, 2), $countMatchInDay);
    }

    /**
     * @param int $countTeams
     * @return int
     */
    private function countMatchInDay(int $countTeams): int
    {
        $countMatchWithTeams = (int) floor($countTeams / 2);
        if (self::MAX_MEET_DAY > $countMatchWithTeams) {
            return $countMatchWithTeams;
        }

        return self::MAX_MEET_DAY;
    }
}