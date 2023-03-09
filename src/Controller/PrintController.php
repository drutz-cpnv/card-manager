<?php

namespace App\Controller;

use App\Data\PrintData;
use App\Entity\PrintRequest;
use App\Form\PrintRequestType;
use App\Repository\PrintRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/impression')]
class PrintController extends AbstractController
{
    #[Route('', name: 'app.print.index', methods: ['GET'])]
    public function index(PrintRequestRepository $printRequestRepository): Response
    {
        return $this->render('print/index.html.twig', [
            'print_requests' => $printRequestRepository->findAll(),
        ]);
    }

    #[Route('/nouvelle', name: 'app.print.new', methods: ['GET', 'POST'])]
    public function new(Request $request, PrintRequestRepository $printRequestRepository): Response
    {
        $data = new PrintData();
        $form = $this->createForm(PrintRequestType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $printRequestRepository->save(PrintRequest::fromData($data), true);

            return $this->redirectToRoute('app.print.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('print/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app.print.show', methods: ['GET'])]
    public function show(PrintRequest $printRequest): Response
    {
        return $this->render('print/show.html.twig', [
            'print_request' => $printRequest,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app.print.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PrintRequest $printRequest, PrintRequestRepository $printRequestRepository): Response
    {
        $form = $this->createForm(PrintRequestType::class, $printRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $printRequestRepository->save($printRequest, true);

            return $this->redirectToRoute('app.print.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('print/edit.html.twig', [
            'print_request' => $printRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app.print.delete', methods: ['POST'])]
    public function delete(Request $request, PrintRequest $printRequest, PrintRequestRepository $printRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$printRequest->getId(), $request->request->get('_token'))) {
            $printRequestRepository->remove($printRequest, true);
        }

        return $this->redirectToRoute('app.print.index', [], Response::HTTP_SEE_OTHER);
    }
}
