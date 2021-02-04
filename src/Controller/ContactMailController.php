<?php

namespace App\Controller;

use App\Form\AppartmentType;
use App\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactMailController extends AbstractController
{

    /**
     * @Route("/email")
     * @param MailerInterface $mailer
     * @throws \Symfony\Component\Form\Exception\OutOfBoundsException
     */
    public function sendEmail(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);


        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($form->get("subject"))
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        // ...
    }

}
