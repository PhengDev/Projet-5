<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    
    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function index(Request $request, ContactNotification $notification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notifyContact($contact);
            $this->addFlash('success','Votre émail a bien été envoyer');
            return $this->redirectToRoute("contact");
        }
        return $this->render("contact/index.html.twig",[
            'form'=> $form->createView(),
            'current_menu' => 'contact'
        ]);
    }
}
