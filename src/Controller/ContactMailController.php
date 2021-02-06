<?php

namespace App\Controller;

use App\Form\AppartmentType;
use App\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactMailController extends AbstractController
{

    /**
     * @Route("/email")
     * @param MailerInterface $mailer
     * @param Request $request
     * @throws \Symfony\Component\Form\Exception\OutOfBoundsException
     */
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);


        $email = (new Email())
            ->from($request->get('email'))
            ->to("noreply@eaw.com")
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($request->get('subject'))
            ->text($request->get("message"));

        $mailer->send($email);


        return new Response();
    }

}
