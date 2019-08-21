<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $property = $paginator->paginate($this->respository->findAllVisible(),
        $request->query->getInt('page',1),12);
        dump($property);
        $this->em->flush();
        return $this->render("property/index.html.twig", [
            'current_menu' => 'properties',
            'properties' => $property
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
            $comment = $property->findLatest();
        }
        return $this->render('property/show.html.twig',[
            'property' => $property,
            'comment'=> $comment,
            'current_menu' => 'properties'
        ]);
    }
}