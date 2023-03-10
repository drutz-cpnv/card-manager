<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\CardRepository;
use App\Repository\EmployeeRepository;
use App\Service\CardService;
use App\Service\VirtualCardService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personnel')]
class EmployeeController extends BaseController
{
    #[Route('', name: 'app.employee.index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'app.employee.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeRepository $employeeRepository): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeRepository->save($employee, true);

            return $this->redirectToRoute('app.employee.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app.employee.show', methods: ['GET'])]
    public function show(Employee $employee): Response
    {
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app.employee.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employee $employee, EmployeeRepository $employeeRepository): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee->setUpdatedAt(new \DateTimeImmutable());
            $employeeRepository->save($employee, true);

            return $this->redirectToRoute('app.employee.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/nouvelle-carte', name: 'app.employee.create_card', methods: ['GET'])]
    public function createCard(Request $request, Employee $employee, CardService $cardService, EntityManagerInterface $em, CardRepository $cardRepository): Response
    {
        if(!$this->isGranted('CARD_CREATE', $employee)) {
            $this->addNotification("Veuillez vous assurer que tous les pré-requis de la création d'une carte sont remplis pour cet employé. <a href=\"#\">Voir la documentation</a>");
            return $this->redirectToRoute('app.employee.show', ['id' => $employee->getId()], Response::HTTP_SEE_OTHER);
        }

        $card = $cardService->create($employee);
        $cardRepository->save($card, true);

        return $this->render('employee/create_card.html.twig', [
            'employee' => $employee,
            'card' => $card,
        ]);
    }

    #[Route('/{id}/carte-virtuelle', name: 'app.employee.create_vcard', methods: ['GET', 'POST'])]
    public function getVCard(Request $request, Employee $employee, VirtualCardService $virtualCardService): Response
    {
        $virtualCardService->create($employee);
        $card = Card::createFromEmployee($employee);

        return $this->render('employee/create_card.html.twig', [
            'employee' => $employee,
            'card' => $card,
        ]);
    }

    #[Route('/{id}', name: 'app.employee.delete', methods: ['POST'])]
    public function delete(Request $request, Employee $employee, EmployeeRepository $employeeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employee->getId(), $request->request->get('_token'))) {
            $employeeRepository->remove($employee, true);
        }

        return $this->redirectToRoute('app.employee.index', [], Response::HTTP_SEE_OTHER);
    }
}
