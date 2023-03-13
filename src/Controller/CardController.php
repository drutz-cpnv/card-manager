<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;

#[Route('/card')]
class CardController extends BaseController
{
    #[Route('', name: 'app.card.index', methods: ['GET'])]
    public function index(CardRepository $cardRepository): Response
    {
        return $this->render('card/index.html.twig', [
            'cards' => $cardRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app.card.show', methods: ['GET'])]
    public function show(Card $card): Response
    {
        return $this->render('card/show.html.twig', [
            'card' => $card,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app.card.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Card $card, CardRepository $cardRepository): Response
    {
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card->setUpdatedAt(new \DateTimeImmutable());
            $cardRepository->save($card, true);

            return $this->redirectToRoute('app.card.show', ['id' => $card->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('card/edit.html.twig', [
            'card' => $card,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/imprime', name: 'app.card.printed', methods: ['POST'])]
    public function printed(Request $request, Card $card, CardRepository $cardRepository): Response
    {
        if ($this->isCsrfTokenValid('printed'.$card->getId(), $request->request->get('_token'))) {
            $card->setToPrint(!$card->isToPrint());
            $card->setUpdatedAt(new \DateTimeImmutable());
            $cardRepository->save($card, true);
        }

        return $this->redirectToRoute('app.card.show', ['id' => $card->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app.card.delete', methods: ['POST'])]
    public function delete(Request $request, Card $card, CardRepository $cardRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$card->getId(), $request->request->get('_token'))) {
            $cardRepository->remove($card, true);
        }

        return $this->redirectToRoute('app.card.index', [], Response::HTTP_SEE_OTHER);
    }
}
