<?php

namespace App\Controller;

use App\Entity\Facility;
use App\Form\FacilityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacilityController extends AbstractController
{
    /**
     * @Route("/facility", name="facility")
     */
    public function index(): Response
    {
        return $this->render('facility/index.html.twig', [
            'controller_name' => 'FacilityController',
        ]);
    }

    /**
     * @Route("/facility/create")
     */
    public function createFacility(Request $request){
        $facility = new Facility();
        $form = $this->createForm(FacilityType::class, $facility);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //get data from form
            $facility = $form->getData();
            $entityManager = $this->getDoctrine() -> getManager();
            $entityManager -> persist($facility);
            $entityManager->flush();
            return new Response("Succes");
        }
        return $this ->render('genericForm.html.twig', [
            'form' => $form->createView(),
            'title' => "Create facility"
        ]);
    }
}
