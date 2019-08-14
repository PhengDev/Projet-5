<?php

namespace App\Controller\Admin;


use App\Repository\PropertyRepository;
use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends AbstractController
{
     /**
     * @var PropertyRespository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index(): Response
    {
        $property = $this->repository->findAllVisible();
        return $this->render("admin/property/index.html.twig",[
            'properties'=>$property
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.property.edit")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property)
    {
        $form = $this->createForm(PropertyType::class, $property);
        return $this->render("admin/property/edit.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

}