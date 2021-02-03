<?php

namespace App\Controller;

use App\Entity\AppartmentPricing;
use App\Form\AppartmentPricingType;
use App\Repository\AppartmentPricingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/appartmentpricing")
 */
class AppartmentPricingController extends AbstractController
{
    /**
     * @Route("/", name="appartment_pricing_index", methods={"GET"})
     */
    public function index(AppartmentPricingRepository $appartmentPricingRepository): Response
    {
        return $this->render('appartment_pricing/index.html.twig', [
            'appartment_pricings' => $appartmentPricingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="appartment_pricing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $appartmentPricing = new AppartmentPricing();
        $form = $this->createForm(AppartmentPricingType::class, $appartmentPricing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appartmentPricing);
            $entityManager->flush();

            return $this->redirectToRoute('appartment_pricing_index');
        }

        return $this->render('appartment_pricing/new.html.twig', [
            'appartment_pricing' => $appartmentPricing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="appartment_pricing_show", methods={"GET"})
     */
    public function show(AppartmentPricing $appartmentPricing): Response
    {
        return $this->render('appartment_pricing/show.html.twig', [
            'appartment_pricing' => $appartmentPricing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="appartment_pricing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AppartmentPricing $appartmentPricing): Response
    {
        $form = $this->createForm(AppartmentPricingType::class, $appartmentPricing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('appartment_pricing_index');
        }

        return $this->render('appartment_pricing/edit.html.twig', [
            'appartment_pricing' => $appartmentPricing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="appartment_pricing_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AppartmentPricing $appartmentPricing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appartmentPricing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appartmentPricing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appartment_pricing_index');
    }
}
