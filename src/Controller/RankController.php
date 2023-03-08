<?php

namespace App\Controller;

use App\Data\RankData;
use App\Entity\Rank;
use App\Form\RankType;
use App\Repository\RankRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/grades')]
class RankController extends AbstractController
{
    #[Route('', name: 'app.rank.index', methods: ['GET'])]
    public function index(RankRepository $rankRepository): Response
    {
        return $this->render('rank/index.html.twig', [
            'ranks' => $rankRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'app.rank.new', methods: ['GET', 'POST'])]
    public function new(Request $request, RankRepository $rankRepository): Response
    {
        $rankData = new RankData();
        $form = $this->createForm(RankType::class, $rankData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rankRepository->save(Rank::createFromData($rankData), true);

            return $this->redirectToRoute('app.rank.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rank/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app.rank.show', methods: ['GET'])]
    public function show(Rank $rank): Response
    {
        return $this->render('rank/show.html.twig', [
            'rank' => $rank,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app.rank.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rank $rank, RankRepository $rankRepository): Response
    {
        $data = $rank->getRankData();
        $form = $this->createForm(RankType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rankRepository->save($rank->updateFromData($data), true);

            return $this->redirectToRoute('app.rank.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rank/edit.html.twig', [
            'rank' => $rank,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app.rank.delete', methods: ['POST'])]
    public function delete(Request $request, Rank $rank, RankRepository $rankRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rank->getId(), $request->request->get('_token'))) {
            $rankRepository->remove($rank, true);
        }

        return $this->redirectToRoute('app.rank.index', [], Response::HTTP_SEE_OTHER);
    }
}
