<?php

namespace Boutique\ProduitsBundle\Controller;

use Faker;
use FOS\RestBundle\View\View;
use Boutique\ProduitsBundle\Entity\Image;
use Boutique\ProduitsBundle\Entity\Produit;
use Boutique\ProduitsBundle\Entity\Category;
use Boutique\ProduitsBundle\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Boutique\ProduitsBundle\Entity\ImagePrincipale;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Produit controller.
 * 
 * @Route("produit")
 */
class ProduitController extends Controller
{
    /**
    * @Route("/searchproducts" , name="searchproducts")
    */
    //FORMULAIRE SEARCH
      
    public function searchProductsAction(Request $request) {

        // $_GET parameters
        //$request->query->get('name');
    
        // $_POST parameters
        // $request->request->get('name');
    
        $em = $this->getDoctrine()->getManager();

        //POST
        $search = $request->request->get('search');

        $products = $em->getRepository(Produit::class)->sortProductByName($search);

        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render("produit/index.html.twig",
            [
                'products' => $products,
                'categories' => $categories
            ]
        );
    }
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="produit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('BoutiqueProduitsBundle:Produit')->findAll();

        $categories = $em->getRepository('BoutiqueProduitsBundle:Category')->findAll();

        //dump($categories);

        return $this->render('produit/index.html.twig', array(
            'products' => $products,
            'categories' => $categories
        ));
    }
    /**   
    * @Route("/sortproductsbyname", name="sortproducts")
    */

    public function sortProductsByNameAction(Request $request) {
        
        if ($request->isXmlHttpRequest()) {

            $orderby = $request->request->get('orderby');
            $column = $request->request->get('column');

            $em = $this->getDoctrine()->getManager();

            if ($column == 'name') {
                $products = $em->getRepository(Produit::class)->findBy([],['name' => $orderby]);
            } else {
                $products = $em->getRepository(Produit::class)->findBy([],['price' => $orderby]);
            }
            return $this->render('produit/productajax.html.twig', ['products' => $products]);

        }   
    }

    // si on veut definir une nouvelle route mannuellement

    /**
     * @Rest\Get("/getproduits")
     * @Rest\View()
     */

    public function getProduitsAction() {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Produit::class)->findAll();
        
        //$newTab = [];

        // foreach($products as $product) {
            
        //     $newTab[] = [
        //         'id' => $product->getId(),
        //         'name' => $product->getName(),
        //         'price' => $product->getPrice(),
        //         'description' => $product->getDescription()
        //     ];
        // }
        //return new JsonResponse($newTab);
        // Création d'une vue FOSRestBundle
        //$view = View::create($newTab);
        $view = View::create($products);
        $view->setFormat('json');

        // Gestion de la réponse
        return $view;

    }

    public function getProduitAction($id) {

        //$id = $request->get('id'); //recuperer le get dans l'url 
        // plus besoin de request pour envoyé du JSON
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Produit::class)->find($id);

        $newTab;

        if ($product) {

            $newTab = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription()
            ];
            return new JsonResponse($newTab);

        } else {
            return new JsonResponse(
                ['message' => 'Place not found'], 
                Response::HTTP_NOT_FOUND
            );
        }

        return new Response(null);

    }


    /**
    * @Route("/displaycart" , name="cart")
    */
    public function displayCartAction(Request $request) {

        $session = $this->get('session');
       
        $cart = $session->get('cart');

        //dump($cart);

        $em = $this->getDoctrine()->getManager();

        $subtotal = 0;
        $products = [];
        
        if (isset($cart)) {
            for ( $i = 0 ; $i < count($cart) ; $i++) {
            
                $products[$i]['productDetails'] = $em->getRepository(Produit::class)->find($cart[$i]['idproduit']);
                $products[$i]['quantity'] = $cart[$i]['qteproduit'];
                $products[$i]['total'] = $products[$i]['productDetails']->getPrice() * $cart[$i]['qteproduit'];
                $subtotal += $products[$i]['total'];
                
                //dump($products);
            }
            
            //dump($products);


            $orders = $session->set('orders', $products); 
        } 
        
        return $this->render("produit/cart.html.twig", 
            [
                'products' => $products,
                'subtotal' => $subtotal
            ]
        );

    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="produit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        // $faker = Faker\Factory::create('fr_FR');

        // $em = $this->getDoctrine()->getManager();
 
        // for ($i = 0; $i < 50; $i++) {
        //     $produit = new Produit();
            
        //     $produit->setName($faker->name);
        //     $produit->setDescription($faker->text);
        //     $produit->setPrice($faker->randomFloat(2,10,1000));
        //     $produit->setQuantity($faker->numberBetween(1,100));
        //     for ($l = 0; $l < 50; $l++) {
        //         $image = new ImagePrincipale();
        //         $image->setAlt($faker->imageUrl(640,480));
        //         $image->setPath($faker->imageUrl(640,480));
        //         $produit->setImagePrincipale($image);
        //     }
            
        //     $em->persist($produit);
        // }
 
        // $em->flush();

        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

            

        if ($form->isSubmitted() && $form->isValid()) {
            $x = $form->getData();
            //dump($x);

            $images = $x->getImages();
            //dump($images);

            foreach ($images as $image) {
                $image->setProduit($produit);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_show', array('id' => $produit->getId()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{id}", name="produit_show")
     * @Method("GET")
     */
    public function showAction(Produit $produit)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('BoutiqueProduitsBundle:Category')->findAll();

        $images = $produit->getImages();

        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'categories' => $categories
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{id}/edit", name="produit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('Boutique\ProduitsBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_edit', array('id' => $produit->getId()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     * @Route("/{id}", name="produit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    

    /**
    * @Route("/addtocart/{id}" , name="addtocart")
    */
    public function addToCartAction(Request $request,$id) {

        $quantity = $request->request->get('quantity');

        $session = $this->get('session'); //appel au services session

        //$session->clear();


        $tab['idproduit'] = $id;
        $tab['qteproduit'] = $quantity;
       
        
        $cart = $session->get('cart');

        $x = false;
        
        if ($cart) {
            for ($i = 0; $i < count($cart) ; $i++) {

                if ($cart[$i]['idproduit'] == $id) {
    
                    $cart[$i]['qteproduit'] += $quantity;
    
                    $x = true;
                } 
            }
        }

        if(!$x) {
            $cart[] = $tab;
        }
        
        $session->set('cart', $cart);

        $getCart = $session->get('cart');

        //dump($getCart);

        return $this->redirectToRoute("cart");
        
    }

    /**
    * @Route("/deletetocart/{id}" , name="deletetocart")
    */
    public function deleteToCartAction(Request $request,$id) {

        $session = $this->get('session');
        $cart = $session->get('cart');

        foreach( $cart as $clef => $produit ) {

            if ( $id == $produit['idproduit'] ) {
                unset($cart[$clef]);
            }
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('cart');

    }
   
}
