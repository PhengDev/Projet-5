<?php
namespace App\Controller;
use App\Entity\User;
use App\Services\Mailer;
use App\Form\ResettingType;
use App\Form\SelectEmailType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
/**
 * @Route("/renouvellement-mot-de-passe")
 */
class ResettingController extends Controller
{
    /**
     * @Route("/requete", name="request_resetting")
     */
    public function request(Request $request, TokenGeneratorInterface $tokenGenerator, ContactNotification $notification)
    {
        // création d'un formulaire "à la volée", afin que l'internaute puisse renseigner son mail
       $user = new User();
        $form = $this->createForm(SelectEmailType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $notification->resetPass($user);
            $user->setToken($tokenGenerator->generateToken());
            $user->setPasswordRequestedAt(new \Datetime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "Un mail va vous être envoyé afin que vous puissiez renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h.");
            return $this->redirectToRoute("login");
        }
        return $this->render('resetting/request.html.twig', [
            'form' => $form->createView()
        ]);
    }
 
    private function isRequestInTime(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null)
        {
            return false;        
        }
        
        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();
        $daySeconds = 60 * 10;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }
    /**
     * @Route("/{id}/", name="resetting")
     */
    public function resetting(User $user, $token, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($user->getToken() === null || $token !== $user->getToken() || !$this->isRequestInTime($user->getPasswordRequestedAt()))
        {
            throw new AccessDeniedHttpException();
        }
        $form = $this->createForm(ResettingType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setToken(null);
            $user->setPasswordRequestedAt(null);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "Votre mot de passe a été renouvelé.");
            return $this->redirectToRoute('login');
        }
        return $this->render('resetting/index.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
}