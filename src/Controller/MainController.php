<?php

namespace App\Controller;

use App\Repository\FacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     * @param FacilityRepository $facilityRepository
     * @return Response
     */
    public function index(FacilityRepository $facilityRepository): Response
    {


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'facilities' => $facilityRepository->findAll()
        ]);
    }
}
