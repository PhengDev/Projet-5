<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    /**
     * @Route("/", name="home")
     * @param PropertyRespository $repository
     * @return Response
     */
    public function index(PropertyRepository $repository, UserRepository $user): Response
    {
        $properties = $repository->findLatest();
        $users = $user->findAll();
        return $this->render("pages/home.html.twig",[
            'properties'=>$properties,
            'users'=>$users
        ]);
    }
}
