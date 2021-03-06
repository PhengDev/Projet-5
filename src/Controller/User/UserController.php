<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $users =  $this->em->getRepository('App:User')->findAll();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($users->getEmail() === $user->getEmail()){
                $request->getSession()->getFlashBag()->add('error', 'Adresse email déjà utilisé');
            } else {
            $this->em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Votre profil bien a été modifié');
            return $this->redirectToRoute('profil');
            }
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
            'validation_groups' => array('User','password'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Votre mot de passe a été modifié');
            return $this->redirectToRoute('profil');
        }else {
            $form->addError(new FormError('Ancien mot de passe incorrect'));
        }
    	return $this->render('profil/editPassword.html.twig', array(
    		'form' => $form->createView(),
    	));
    }
}