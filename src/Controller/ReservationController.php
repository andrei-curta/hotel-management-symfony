<?php

namespace App\Controller;

use App\Entity\Appartment;
use App\Entity\Reservation;
use App\Entity\Service;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use phpDocumentor\Reflection\PseudoTypes\True_;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     * @param ReservationRepository $reservationRepository
     * @param TokenStorageInterface $tokenStorage
     * @return Response
     */
    public function index(ReservationRepository $reservationRepository, TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();

        $reservations = [];

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $reservations = $reservationRepository->findAll();
        } else {
            $reservations = $reservationRepository->findByUser($user);
        }

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    private function hasAccessToReservation(User $user, Reservation $reservation): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return True;
        } elseif ($reservation->getIDUser()->getId() == $user->getId()) {
            return True;
        } else {
            return False;
        }
    }

    private function calculateTotalPricePerAppartment($startDate, $endDate, Appartment $appartment)
    {
        $numberOfDays = $endDate->diff($startDate)->format("%a");

        $price = $appartment->getCurrentAppartmentPricing()->getPrice();
        if ($price == null) {
            $price = $appartment->getBasePrice();
        }

        return $numberOfDays * $price;
    }


    private function isRoomAvabileInInterval(Appartment $appartment, $startDate, $endDate)
    {

        $sql = "select 1
        from reservation
                 inner join reservation_appartment ra on reservation.id = ra.reservation_id
        where ra.appartment_id =" . $appartment->getId() . "
          and (STR_TO_DATE( '" . $startDate->format('Y-m-d') . "','%Y-%m-%d') between start_date and end_date or STR_TO_DATE('" . $endDate->format('Y-m-d') . "','%Y-%m-%d') between start_date and end_date)";


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
    public function new(Request $request, TokenStorageInterface $tokenStorage, MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //calculate the price and check if reservation is valid

            if ($reservation->getAppartments()->isEmpty()) {
                $form->addError(new FormError("No appartment selected"));
            } elseif (!$this->isRoomAvabileInInterval($reservation->getAppartments()[0], $reservation->getStartDate(), $reservation->getEndDate())) {
                $err = new FormError("Appartment already reserved in that interval");
                $form->addError($err);
            } else {

                $appartmentPrice = $this->calculateTotalPricePerAppartment($reservation->getStartDate(), $reservation->getEndDate(), $reservation->getAppartments()[0]);
                $servicesPrice = $reservation->calculateTotalServicesPrice();
                $totalPrice = $appartmentPrice + $servicesPrice;
                $reservation->setTotalPrice($totalPrice);

                //set the current user as the person who reserves
                dump($tokenStorage->getToken()->getUser());
                $user = $tokenStorage->getToken()->getUser();
                $reservation->setIDUser($user);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reservation);
                $entityManager->flush();

                //send mail
                $email = (new Email())
                    ->from("noreply@eaw.com")
                    ->to($user->getUsername())
                    //->cc('cc@example.com')
                    //->bcc('bcc@example.com')
                    //->replyTo('fabien@example.com')
                    //->priority(Email::PRIORITY_HIGH)
                    ->subject("New reservation")
                    ->text("Pack your bags, you are going on an adventure. And don't forget to pay the cost of $totalPrice");

                $mailer->send($email);


                return $this->redirectToRoute('main');
            }
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation, TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->hasAccessToReservation($user, $reservation)) {
            return new Response("You do not have access to this reservation", Response::HTTP_FORBIDDEN);
        }

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation, TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->hasAccessToReservation($user, $reservation)) {
            return new Response("You do not have access to this reservation", Response::HTTP_FORBIDDEN);
        }

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
    public function delete(Request $request, Reservation $reservation, TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->hasAccessToReservation($user, $reservation)) {
            return new Response("You do not have access to this reservation", Response::HTTP_FORBIDDEN);
        }

        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }
}
