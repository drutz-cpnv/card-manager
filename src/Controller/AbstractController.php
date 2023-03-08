<?php

namespace App\Controller;

use App\Service\FlashService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    public function __construct(
        private readonly RequestStack $requestStack
    )
    {
    }


    /**
     * Redirige l'utilisateur vers la page précédente ou la route en cas de fallback.
     */
    protected function redirectBack(string $route, array $params = []): RedirectResponse
    {
        $stack = $this->requestStack;
        $request = $stack->getCurrentRequest();
        if ($request && $request->server->get('HTTP_REFERER')) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        return $this->redirectToRoute($route, $params);
    }

    protected function addNotification(string $message, ?string $title = null, $duration = 5000): void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        $flashBag->add('notification', ['id' => uniqid(), 'title' => $title, 'content' => $message, 'duration' => $duration]);
    }

}