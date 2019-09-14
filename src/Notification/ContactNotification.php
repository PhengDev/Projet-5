<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;
use App\Entity\Contact;

class ContactNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

     /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('DrakeBallShop: Contact :'. $contact->getEmail()))
        ->setFrom('pheng.ly300@gmail.com')
        ->setTo('pheng.ly300@gmail.com')
        ->setReplyTo($contact->getEmail())
        ->setBody($this->renderer->render('emails/contact.html.twig', [
            'contact' => $contact
        ]), 'text/html');
        $this->mailer->send($message);
    }

    public function resetPass(User $user)
    {
        $message = (new \Swift_Message('DrakeBallShop: ResetPassword :'. $user->getEmail()))
        ->setFrom('pheng.ly300@gmail.com')
        ->setTo('pheng.ly300@gmail.com')
        ->setReplyTo($user->getEmail())
        ->setBody($this->renderer->render('resetting/mail.html.twig', [
            'user' => $user
        ]), 'text/html');
        $this->mailer->send($message);
    }
}