<?php

namespace App\Controller;

use App\Entity\Facility;
use App\Form\FacilityType;
use App\Repository\FacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facility")
 */
class FacilityController extends AbstractController
{
    /**
     * @Route("/", name="facility_index", methods={"GET"})
     */
    public function index(FacilityRepository $facilityRepository): Response
    {
        return $this->render('facility/index.html.twig', [
            'facilities' => $facilityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="facility_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $facility = new Facility();
        $form = $this->createForm(FacilityType::class, $facility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facility);
            $entityManager->flush();

            return $this->redirectToRoute('facility_index');
        }

        return $this->render('facility/new.html.twig', [
            'facility' => $facility,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facility_show", methods={"GET"})
     */
    public function show(Facility $facility): Response
    {
        return $this->render('facility/show.html.twig', [
            'facility' => $facility,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facility_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Facility $facility): Response
    {
        $form = $this->createForm(FacilityType::class, $facility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facility_index');
        }

        return $this->render('facility/edit.html.twig', [
            'facility' => $facility,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facility_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Facility $facility): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facility->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($facility);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facility_index');
    }
}
