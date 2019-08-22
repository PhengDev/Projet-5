<?php

namespace App\Controller;

use App\Entity\Comment;
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
    public function index(PaginatorInterface $paginator, Request $request, PropertyRepository $repository): Response
    {
        $property = $paginator->paginate($this->respository->findAllVisible(),
        $request->query->getInt('page',1),12);
        dump($property);
        $this->em->flush();
        $results = $repository->findAll();
        return $this->render("property/index.html.twig", [
            'current_menu' => 'properties',
            'properties' => $property,
            'results' => $results
        ]);
    }

    /**
     * @Route("/collection/{slug}-{id}", name="property.show",requirements={"slug": "[a-z0.-9\-]*"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug,  PropertyRepository $repository): Response
    {
        if ($property->getSlug() !== $slug){
            return $this->redirectToRoute('properties.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
           
        }
        $results = $repository->findAll();
        return $this->render('property/show.html.twig',[
            'property' => $property,
            'current_menu' => 'properties',
            'results' => $results
        ]);
    }

     /**
   *
   * @Route("/search", name="ajax_search")
   * @Method("GET")
   */
  public function searchAction(Request $request)
  {
      $em = $this->getDoctrine()->getManager();
      $requestString = $request->get('q');
      $properties =  $em->getRepository('App:Property')->findPropertyByString($requestString);
      if(!$properties) {
          $result['properties']['error'] = "Aucun résultat";
      } else {
          $result['properties'] = $this->getRealProperty($properties);
         
      }
      return new JsonResponse($result);
  }
 
  public function getRealProperty($properties){
    foreach ($properties as $property){
        $realProperty[$property->getId()] = $property->getTitle();
    }
    return $realProperty;
}
}