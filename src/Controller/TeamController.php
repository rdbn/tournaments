<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    public function __construct(private TeamRepository $repository)
    {
    }

    #[Route('/teams/', name: 'teams')]
    public function teams(Request $request): Response
    {
        $form = $this->createForm(TeamType::class, new Team());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->flush($form->getData());
            return $this->redirectToRoute('teams');
        }

        $teams = $this->repository->findAll();

        return $this->render('page/teams.html.twig', [
            'form' => $form->createView(),
            'teams' => $teams,
        ]);
    }

    #[Route('/teams/delete/{id}', name: 'teams_delete')]
    public function teamsDelete(int $id): RedirectResponse
    {
        $tournament = $this->repository->findOneBy(['id' => $id]);
        $this->repository->remove($tournament);

        return $this->redirectToRoute('teams');
    }
}