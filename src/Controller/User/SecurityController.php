<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{

    /**
     * 
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'current_menu' => 'login',
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user,[
           'validation_groups' => array('User', 'registration'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            return $this->redirect($this->generateUrl('login'));
        }
        return $this->render('security/registration.html.twig', [
            'current_menu' => 'registration',
            'form' => $form->createView()
        ]);
    }

     /**
    * @param User $user
     * @Route("/forgotten_password", name="app_forgotten_password")
     */
    public function forgottenPassword(Request $request, \Swift_Mailer $mailer,TokenGeneratorInterface $tokenGenerator)
    {
        if ($request->isMethod('POST')) {
 
            $email = $request->request->get('email');
 
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
           
            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('login');
            }
            $token = $tokenGenerator->generateToken();
 
            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('login');
            }
 
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
 
            $message = (new \Swift_Message('Réinitialisation du mot de passe'))
                ->setFrom('pheng.ly300@gmail.com','DrakeBallShop')
                ->setTo($user->getEmail())
                ->setBody(
                    "Veuillez cliquer sur le lien pour réinitialiser votre mot de passe : " . $url,
                    'text/html'
                );
 
            $mailer->send($message);
 
            $this->addFlash('success', 'Mail envoyé');
 
            return $this->redirectToRoute('login');
        }
 
        return $this->render('security/forgotten_password.html.twig');
    }

    /**
     * @param User $user
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
 
        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
 
            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);
          
            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('login');
            }
 
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();
 
            $this->addFlash('success', 'Mot de passe mis à jour');
 
            return $this->redirectToRoute('login');
        }else {
 
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }
 
    }
}
