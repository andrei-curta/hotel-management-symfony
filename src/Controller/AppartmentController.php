<?php

namespace App\Controller;

use App\Entity\Appartment;
use App\Entity\Facility;
use App\Form\AppartmentType;
use App\Repository\AppartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/appartment")
 */
class AppartmentController extends AbstractController
{
    /**
     * @Route("/", name="appartment_index", methods={"GET"})
     */
    public function index(AppartmentRepository $appartmentRepository): Response
    {
        return $this->render('appartment/index.html.twig', [
            'appartments' => $appartmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="appartment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $appartment = new Appartment();
        $facilities = $this->getDoctrine()
            ->getRepository(Facility::class)->findAll();

        $form = $this->createForm(AppartmentType::class, $appartment, [
            'facilities' => $facilities,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appartment);
            $entityManager->flush();

            return $this->redirectToRoute('appartment_index');
        }

        return $this->render('appartment/new.html.twig', [
            'appartment' => $appartment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="appartment_show", methods={"GET"})
     */
    public function show(Appartment $appartment): Response
    {
        return $this->render('appartment/show.html.twig', [
            'appartment' => $appartment,
        ]);
    }

    /**
     * @Route("/presentation/{id}", name="appartment_presentation", methods={"GET"})
     */
    public function presentation(Appartment $appartment): Response
    {
        return $this->render('appartment/presentation.html.twig', [
            'appartment' => $appartment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="appartment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Appartment $appartment): Response
    {
        $form = $this->createForm(AppartmentType::class, $appartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('appartment_index');
        }

        return $this->render('appartment/edit.html.twig', [
            'appartment' => $appartment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="appartment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Appartment $appartment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $appartment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appartment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appartment_index');
    }
}
