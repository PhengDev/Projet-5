<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Session\Session;
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
    public function notifyContact(Contact $contact)
    {
        $message = (new \Swift_Message('DrakeBallShop: Contact :'. $contact->getEmail()))
        ->setFrom('pheng.ly300@gmail.com')
        ->setTo('pheng.ly300@gmail.com')
        ->setBody($this->renderer->render('emails/contact.html.twig', [
            'contact' => $contact
        ]), 'text/html');
        $this->mailer->send($message);
    }

    public function validCommand($properties, User $user, Session $session)
    {
        $message = (new \Swift_Message('DrakeBallShop: Validation du commande :'. $user->getUsername()))
        ->setFrom('pheng.ly300@gmail.com','DrakeBallShop')
        ->setTo($user->getEmail())
        ->setBody($this->renderer->render('panier/mail.html.twig', [
            'properties' => $properties,
            "panier" => $session->get('panier')
        ]), 'text/html');

        $messageAdmin = (new \Swift_Message('DrakeBallShop: Validation du commande :'. $user->getUsername()))
        ->setFrom('pheng.ly300@gmail.com','DrakeBallShop : Commande éffectuer par ' . $user->getUsername())
        ->setTo('pheng.ly300@gmail.com')
        ->setBody($this->renderer->render('panier/mailAdmin.html.twig', [
            'properties' => $properties,
            'user' => $user,
            "panier" => $session->get('panier')
        ]), 'text/html');

        $this->mailer->send($message);
        $this->mailer->send($messageAdmin);
    }
    
    public function resetpassword(Contact $contact)
    {
        $message = (new \Swift_Message('DrakeBallShop: Contact :'. $contact->getEmail()))
        ->setFrom('pheng.ly300@gmail.com')
        ->setTo('pheng.ly300@gmail.com')
        ->setBody($this->renderer->render('emails/contact.html.twig', [
            'contact' => $contact
        ]), 'text/html');
        $this->mailer->send($message);
    }
}