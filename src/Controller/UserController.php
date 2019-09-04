<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
     /**
     * @var UserRepository
     */
    private $repository;
    private $em;

    public function __construct(UserRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

     /**
     * @Route("/profil}", name="profil")
     * @param Request $request
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

      /**
     * @Route("/profil/{slug}-{id}", name="profil",requirements={"slug": "[a-z0.-9\-]*"})
     * @param User $user
     * @return Response
     */
    public function show(string $slug, User $user ): Response
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

     /**
     * @Route("/profil/property/{id}", name="profil.property.edit",  methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', "Votre modification a été bien éffectuer !");
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render("admin/property/edit.html.twig", [
            'property' => $user,
            'form' => $form->createView()
        ]);
    }
}