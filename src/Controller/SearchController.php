<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $entities =  $em->getRepository('App:Entity')->findEntitiesByString($requestString);
        if(!$entities) {
            $result['entities']['error'] = "keine Einträge gefunden";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getFoo();
        }
        return $realEntities;
    }
  }