<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\TournamentType;
use App\Repository\TournamentRepository;
use App\Service\Tournament\SlugService;
use App\Service\Tournament\TournamentsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    public function __construct(private TournamentRepository $repository, private EntityManagerInterface $em)
    {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $tournaments = $this->repository->findAll();

        return $this->render('page/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }

    #[Route('/tournaments/', name: 'tournaments')]
    public function tournaments(Request $request): Response
    {
        $tournament = new Tournament();
        $form = $this->createForm(TournamentType::class, $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tournament->setSlug(SlugService::createSlug($tournament->getName()));

            $this->em->persist($tournament);
            $this->em->flush();

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
        $tournament = $this->repository->findOneBy(['slug' => $slug]);
        if ($tournament === null) {
            throw new NotFoundHttpException('Tournament not found');
        }

        return $this->render('page/tournamentsSlug.html.twig', [
            'tournament' => $tournament,
            'teamGenerator' => $service->getMeshMatchTeam($tournament),
        ]);
    }

    #[Route('/tournaments/delete/{slug}', name: 'tournaments_delete')]
    public function tournamentsDelete(string $slug): RedirectResponse
    {
        $tournament = $this->repository->findOneBy(['slug' => $slug]);
        if ($tournament === null) {
            throw new NotFoundHttpException('Tournament not found');
        }

        $this->em->remove($tournament);
        $this->em->flush();

        return $this->redirectToRoute('tournaments');
    }
}