<?php

namespace App\Controller;

use App\Entity\Appartment;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    private function calculateTotalPricePerAppartment($startDate, $endDate, Appartment $appartment)
    {
        $numberOfDays = $endDate->diff($startDate)->format("%a");

        //todo: tinut cont de suprapuneri de perioade
        $price = $appartment->getCurrentAppartmentPricing()->getPrice();

        return $numberOfDays * $price;
    }

    private function isRoomAvabileInInterval(Appartment $appartment, $startDate, $endDate)
    {

        $sql = "select 1
        from reservation
                 inner join reservation_appartment ra on reservation.id = ra.reservation_id
        where ra.appartment_id =" . $appartment->getId() . "
          and (STR_TO_DATE( '".  $startDate->format('Y-m-d') . "','%Y-%m-%d') between start_date and end_date or STR_TO_DATE('" . $endDate->format('Y-m-d') . "','%Y-%m-%d') between start_date and end_date)";



        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
//        $stmt->setParameter(':appartment_id',5);
//        $stmt->setParameter(':startD', $startDate);
//        $stmt->setParameter(':endD', $endDate);

        $stmt->execute();
        $reservations = $stmt->fetchAll();

        return count($reservations) === 0;
    }

    /**
     * @Route("/new", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request, TokenStorageInterface $tokenStorage): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //calculate the price and check if reservation is valid

            if (!$this->isRoomAvabileInInterval($reservation->getAppartments()[0], $reservation->getStartDate(), $reservation->getEndDate())) {
                return new Response("Appartment already reserved", Response::HTTP_FORBIDDEN);
            }

            $reservation->setTotalPrice($this->calculateTotalPricePerAppartment($reservation->getStartDate(), $reservation->getEndDate(), $reservation->getAppartments()[0]));

            //set the current user as the person who reserves
            dump($tokenStorage->getToken()->getUser());
            $reservation->setIDUser($tokenStorage->getToken()->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }
}
