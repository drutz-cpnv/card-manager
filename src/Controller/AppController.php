<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends BaseController
{

    #[Route("", name: "app.home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

}