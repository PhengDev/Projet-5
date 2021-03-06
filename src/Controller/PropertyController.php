<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class PropertyController extends AbstractController
{

    /**
     * @var Propertyrepository
     */
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/collection", name="property.collection")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $property = $paginator->paginate($this->repository->findAllVisible(),
        $request->query->getInt('page',1),12);
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
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug){
            return $this->redirectToRoute('properties.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
           
        }
        return $this->render('property/show.html.twig',[
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }

    /**
     *
     * @Route("/search", name="ajax_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
   
    $requestString = $request->get('q');
    $properties =  $this->em->getRepository('App:Property')->findPropertyByString($requestString);

      if(!$properties) {
          $result['properties']['error']= "Aucun résultat";
      } else {
          $result['properties'] = $this->getSlugProperty($properties);
          $test['test'] = $this->getTitleProperty($properties);
      }
      return new JsonResponse($result);
  }
 
  public function getSlugProperty($properties){
    foreach ($properties as $property){
        $realProperty[$property->getId()] = $property->getSlug();
    }
    return $realProperty;
}
public function getTitleProperty($properties){
    foreach ($properties as $property){
        $realProperty[$property->getId()] = $property->getTitle();
    }
    return $realProperty;
}

}