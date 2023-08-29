<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\TournamentType;
use App\Repository\TournamentRepository;
use App\Service\Tournament\SlugService;
use App\Service\Tournament\TournamentsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    public function __construct(private TournamentRepository $repository)
    {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $tournaments = $this->repository->findBy([]);

        return $this->render('page/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }

    #[Route('/tournaments/', name: 'tournaments')]
    public function tournaments(Request $request): Response
    {
        $form = $this->createForm(TournamentType::class, new Tournament());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->flush($form->getData());
            return $this->redirectToRoute('tournaments');
        }

        $tournaments = $this->repository->findAll();

        return $this->render('page/tournaments.html.twig', [
            'form' => $form->createView(),
            'tournaments' => $tournaments,
        ]);
    }

    #[Route('/tournaments/{slug}', name: 'tournaments_slug')]
    public function tournamentsSlug(string $slug, TournamentsService $service): Response
    {
        $tournament = $this->repository->findOneBy(['name' => SlugService::normalizeName($slug)]);

        return $this->render('page/tournamentsSlug.html.twig', [
            'tournament' => $tournament,
            'teamGenerator' => $service->getMeshMatchTeam($tournament),
        ]);
    }

    #[Route('/tournaments/delete/{slug}', name: 'tournaments_delete')]
    public function tournamentsDelete(string $slug): RedirectResponse
    {
        $tournament = $this->repository->findOneBy(['name' => SlugService::normalizeName($slug)]);
        $this->repository->remove($tournament);

        return $this->redirectToRoute('tournaments');
    }
}