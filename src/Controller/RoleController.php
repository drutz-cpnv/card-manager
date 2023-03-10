<?php

namespace App\Controller;

use App\Data\RoleData;
use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fonction')]
class RoleController extends BaseController
{
    #[Route('', name: 'app.role.index', methods: ['GET'])]
    public function index(RoleRepository $roleRepository): Response
    {
        return $this->render('role/index.html.twig', [
            'roles' => $roleRepository->findAll(),
        ]);
    }

    #[Route('/nouvelle', name: 'app.role.new', methods: ['GET', 'POST'])]
    public function new(Request $request, RoleRepository $roleRepository): Response
    {
        $data = new RoleData();
        $form = $this->createForm(RoleType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roleRepository->save(Role::createFromData($data), true);

            return $this->redirectToRoute('app.role.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('role/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app.role.show', methods: ['GET'])]
    public function show(Role $role): Response
    {
        return $this->render('role/show.html.twig', [
            'role' => $role,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app.role.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Role $role, RoleRepository $roleRepository): Response
    {
        $data = $role->getRoleData();
        $form = $this->createForm(RoleType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roleRepository->save($role->updateFromData($data), true);

            return $this->redirectToRoute('app.role.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('role/edit.html.twig', [
            'role' => $data,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app.role.delete', methods: ['POST'])]
    public function delete(Request $request, Role $role, RoleRepository $roleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token'))) {
            $roleRepository->remove($role, true);
        }

        return $this->redirectToRoute('app.role.index', [], Response::HTTP_SEE_OTHER);
    }
}
