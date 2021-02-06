<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{

    /**
     * @Route("/locale/{localeName}", name="locale", methods={"POST"})
     * @param Request $request
     * @param $localeName
     * @return Response
     */
    public function setLocale(Request $request, $localeName): Response
    {
        $this->get('session')->set('_locale', $localeName);
        $request->setLocale($localeName);
        return new Response();
    }
}
