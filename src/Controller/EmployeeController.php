<?php

namespace App\Controller;

use App\Data\VCardData;
use App\Entity\Card;
use App\Entity\Employee;
use App\Form\CardType;
use App\Form\EmployeeType;
use App\Form\VirtualCardType;
use App\Repository\CardRepository;
use App\Repository\EmployeeRepository;
use App\Service\CardService;
use App\Service\VirtualCardService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
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

            return $this->redirectToRoute('app.employee.show', ['id' => $employee->getId()], Response::HTTP_SEE_OTHER);
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

    #[Route('/{id}/nouvelle-carte', name: 'app.employee.create_card', methods: ['GET', 'POST'])]
    public function createCard(Request $request, Employee $employee, CardService $cardService, EntityManagerInterface $em, CardRepository $cardRepository): Response
    {
        if(!$this->isGranted('CARD_CREATE', $employee)) {
            $this->addNotification("Veuillez vous assurer que tous les pré-requis de la création d'une carte sont remplis pour cet employé. <a href=\"#\">Voir la documentation</a>");
            return $this->redirectToRoute('app.employee.show', ['id' => $employee->getId()], Response::HTTP_SEE_OTHER);
        }

        $card = $cardService->create($employee);

        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cardRepository->save($card, true);
            return $this->redirectToRoute('app.employee.show', ['id' => $employee->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employee/create_card.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/carte-virtuelle', name: 'app.employee.create_vcard', methods: ['GET', 'POST'])]
    public function getVCard(Request $request, Employee $employee, VirtualCardService $virtualCardService): Response
    {
        $data = VCardData::createFromEmployee($employee);
        $form = $this->createForm(VirtualCardType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vcard = $virtualCardService->create($data);

            $path = 'cards/'.time().'.vcf';
            file_put_contents('cards/'.time().'.vcf', $vcard->serialize());
            $file = new File($path);

            return $this->file($file);
        }

        return $this->renderForm('employee/create_vcard.html.twig', [
            'employee' => $employee,
            'form' => $form,
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
