<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommandController extends Controller
{
    public function validationCommandeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('App:Commandes')->find($id);
        
        if (!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas');
        
        $commande->setValider(1);
        $commande->setReference($this->container->get('setNewReference')->reference()); //Service
        $em->flush();   
        
        $session = $this->getRequest()->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
        
        $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre commande')
                ->setFrom('pheng.ly300@gmail.com')
                ->setTo($commande->getUtilisateur()->getEmailCanonical())
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView('emails/livraison.html.twig',array('utilisateur' => $commande->getUtilisateur())));
        
        $this->get('mailer')->send($message);
        
        $this->get('session')->getFlashBag()->add('success','Votre commande est validé avec succès');
        return $this->redirect($this->generateUrl('factures'));
    }
}