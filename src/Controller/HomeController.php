<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\PropertyRepository;
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
    public function index(PropertyRepository $repository): Response
    {
        
        $properties = $repository->findLatest();
        $slideProperties = $repository->findSlider();
        return $this->render("home/index.html.twig",[
            'properties'=>$properties,
            'slideProperties'=>$slideProperties
        ]);
    }

}
