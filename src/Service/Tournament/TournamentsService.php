<?php

declare(strict_types=1);

namespace App\Service\Tournament;

use App\Entity\Team;
use App\Entity\Tournament;
use App\Repository\TeamRepository;

class TournamentsService
{
    public function __construct(private TeamRepository $repository, private TeamTournamentGenerator $generator)
    {
    }

    /**
     * @return Team[]
     */
    public function getMeshMatchTeam(Tournament $tournament): array
    {
        if ($tournament->getMatchTeams() === null) {
            $teams = $this->repository->findAll();
            shuffle($teams);
        } else {
            $teams = $this->repository->findBy(['id' => $tournament->getMatchTeams()]);
        }

        return $this->generator->generate($teams);
    }
}