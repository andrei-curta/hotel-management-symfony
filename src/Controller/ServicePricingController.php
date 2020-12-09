<?php

namespace App\Controller;

use App\Entity\ServicePricing;
use App\Form\ServicePricingType;
use App\Repository\ServicePricingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service/pricing")
 */
class ServicePricingController extends AbstractController
{
    /**
     * @Route("/", name="service_pricing_index", methods={"GET"})
     */
    public function index(ServicePricingRepository $servicePricingRepository): Response
    {
        return $this->render('service_pricing/index.html.twig', [
            'service_pricings' => $servicePricingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="service_pricing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $servicePricing = new ServicePricing();
        $form = $this->createForm(ServicePricingType::class, $servicePricing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($servicePricing);
            $entityManager->flush();

            return $this->redirectToRoute('service_pricing_index');
        }

        return $this->render('service_pricing/new.html.twig', [
            'service_pricing' => $servicePricing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_pricing_show", methods={"GET"})
     */
    public function show(ServicePricing $servicePricing): Response
    {
        return $this->render('service_pricing/show.html.twig', [
            'service_pricing' => $servicePricing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="service_pricing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ServicePricing $servicePricing): Response
    {
        $form = $this->createForm(ServicePricingType::class, $servicePricing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_pricing_index');
        }

        return $this->render('service_pricing/edit.html.twig', [
            'service_pricing' => $servicePricing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_pricing_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ServicePricing $servicePricing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$servicePricing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($servicePricing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service_pricing_index');
    }
}
