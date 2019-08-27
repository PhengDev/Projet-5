<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

class UserController extends AbstractController
{
     /**
     * @var UserRepository
     */
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, ObjectManager $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

      /**
     * @Route("/profil/{slug}-{id}", name="profil",requirements={"slug": "[a-z0.-9\-]*"})
     * @param User $user
     * @return Response
     */
    public function index(User $user, string $slug,  UserRepository $userRepository): Response
    {
        
        if ($user->getSlug() !== $slug){
            return $this->redirectToRoute('profil', [
                'id' => $user->getId(),
                'slug' => $user->getSlug()
            ], 301);
           
        }
        
        return $this->render('pages/profil.html.twig',[
         
            'user' => $user,
            'current_menu' => 'properties'
        ]);
    }
}