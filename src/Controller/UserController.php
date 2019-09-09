<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserController extends AbstractController
{
  
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

      /**
     * @Route("/profil", name="profil")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render("profil/index.html.twig");
    }

    /**
     * @param User $user
     * @Route("/profil-edit", name="profil.edit")
     * @Method({"GET", "POST"})
     */
    public function editProfil(Request $request)
    {
        $user = $this->getUser();
    	$form = $this->createForm(UserType::class, $user, [
            'validation_groups' => array('profil'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Votre profil bien a été modifié');
            return $this->redirectToRoute('profil');
        } 
        return $this->render('profil/editProfil.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @param User $user
     * @Route("/profil-password", name="profil.password")
     * @Method({"GET", "POST"})
     */
    public function changePassword(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
    	$form = $this->createForm(UserType::class, $user, [
            'validation_groups' => array('password'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Votre mot de passe a été modifié');
            return $this->redirect('profil');
        }
    	
    	return $this->render('profil/editPassword.html.twig', array(
    		'form' => $form->createView(),
    	));
    }
}