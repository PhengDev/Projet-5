<?php
namespace App\Controller;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class PanierController extends AbstractController { 
    /**
     * @var PropertyRepository
     */
    private $repository;
    private $em;

    /**
     * @param PropertyRepository $repository
     */
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/panier}", name="panier")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('panier')) $session->set('panier', array());
        $properties = $this->repository->findArray(array_keys($session->get('panier')));
        return $this->render('panier/panier.html.twig',[
            "properties" => $properties,
            "panier" => $session->get('panier')
        ]);
    }
    
    /**
     * @param Request $request
     * @return Response
     */
    public  function nbArticle(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) 
            $articles = 0;
        else
            $articles = count($session->get('panier'));
        
        return $this->render('panier/boutonPanier/boutonPanier.html.twig',[
            "articles" => $articles
        ]);
    }

    /**
     * @Route("/suppimer/{id}", name="panier.suppArticle")
     * @param SessionInterface $session
     * @param $id
     * @return Response
     */
    public function removeArticle(SessionInterface $session, $id)
    {
        $panier = $session->get('panier');
        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier', $panier);
            $this->addFlash('danger', 'Article supprimé avec succès !');
        }
        return $this->redirect($this->generateUrl('panier'));
    }

    /**
     * @Route("/suppimer", name="panier.supprime")
     * @param Request $request
     * @return Response
     */
    public function remove(Request $request): Response
    {
        $session = $request->getSession();
        $session->clear();
        $session->set('panier', array());
        $this->addFlash('success', 'Votre panier à bien été vider');
        return $this->redirect($this->generateUrl('panier'));
    }

    /**
     * @Route("/validation", name="panier.validation",  methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function validation(Request $request): Response
    {
        $session = $request->getSession();
        $session->clear();
        $session->set('panier', array());
       
        $this->addFlash('success', 'Votre commande a bien été éffectuer, Merci pour votre achat !');
        return $this->redirect($this->generateUrl('panier'));
    }

    /**
     * @Route("/ajouter/{id}", name="panier.ajout")
     * @param SessionInterface $session
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function addArticle(SessionInterface $session, Request $request, $id)
    {
        if (!$session->has('panier'))
            $session->set('panier', array());
            $panier = $session->get('panier');
        if (array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null) {
                $panier[$id] = $request->query->get('qte');
                $this->addFlash('success', 'Quantité modifié avec succès !');
            }
        } else {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;
             
            $this->addFlash('success', 'Article ajouté avec succès !');
            
        }
        $session->set('panier', $panier);
        return $this->redirect($this->generateUrl('panier'));
    }

    /**
     * @Route("/livraison", name="panier.livraison")
     * @return Response
     */
    public function delivery(): Response
    {  
        return $this->render('panier/delivery.html.twig');
    }

}