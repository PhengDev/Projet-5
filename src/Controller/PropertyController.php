<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRespository
     */
    private $respository;

    public function __construct(PropertyRepository $respository, ObjectManager $em)
    {
        $this->respository = $respository;
        $this->em = $em;
    }
    /**
     * @Route("/collection", name="property.collection")
     * @return Response
     */

    public function index(): Response
    {
        $property = $this->respository->findAllVisible();
        dump($property);
        $this->em->flush();
        return $this->render("property/index.html.twig", [
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/collection/{slug}-{id}", name="property.show",requirements={"slug": "[a-z0.-9\-]*"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug, Comment $comment): Response
    {
        if ($property->getSlug() !== $slug){
            return $this->redirectToRoute('properties.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);

        }
        return $this->render('property/show.html.twig',[
            'property' => $property,
            'comment' => $comment,
            'current_menu' => 'properties'
        ]);
    }
}