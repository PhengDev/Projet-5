<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
     /**
     * @var PropertyRespository
     */
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
       
        $property = $paginator->paginate($this->repository->findAllVisible(),
        $request->query->getInt('page',1),12);
        return $this->render("admin/property/index.html.twig",[
            'properties'=>$property
        ]);
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', "Votre création a été bien éffectuer !");
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render("admin/property/new.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, Request $request, $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $property = $em->getRepository(Property::class)->find($id);
        $property->setQuantity(5);
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', "Votre suppression a été bien éffectuer !");
        }
        return $this->redirectToRoute('admin.property.index');
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit",  methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', "Votre modification a été bien éffectuer !");
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render("admin/property/edit.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    

}