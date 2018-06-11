<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/30
 * Time: 10:06 PM
 */

namespace LarryBundle\Controller;

use LarryBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductController extends Controller
{
    /**
     * @Route("/product/list", name="list")
     */
    public function listAllAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);

        $products = $repository->findAll();

        return $this->render("larry/product/list.html.twig",
            array("products" => $products, "msg" => "All products have been list here:"));

    }

    /**
     * @Route("/product/view/{productId}", name="view")
     */
    public function viewAction($productId, Request $request)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $productId
            );
        }

        $form = $this->createFormBuilder($product)
            //->add("product", TextType::class) //p.p 5.5+
            ->add("id", "Symfony\Component\Form\Extension\Core\Type\IntegerType",
                array("label" => "Product Id: ", "read_only" => true))
            ->add("name", "Symfony\Component\Form\Extension\Core\Type\TextType",
                array("label" => "Product name: ", "attr" => array("maxlength" => 30)))
            ->add("description", "Symfony\Component\Form\Extension\Core\Type\TextType",
                array("label" => "Product description: ", "attr" => array("maxlength" => 100)))
            ->add("price", "Symfony\Component\Form\Extension\Core\Type\NumberType",
                array("label" => "Product price: ", "scale" => 2, "attr" => array("maxlength" => 10)))
            ->add("save", "Symfony\Component\Form\Extension\Core\Type\SubmitType", array("label" => "Update this product"))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product->setName($form->get("name")->getData());
            $product->setPrice($form->get("price")->getData());
            $product->setDescription($form->get("description")->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->render("larry/product/view.html.twig",
                array("form" => $form->createView(), "productId" => $productId, "msg" => "Updated successfully!"));

        }


        return $this->render("larry/product/view.html.twig",
            array("form" => $form->createView(), "productId" => $productId, "msg" => "You can edit the product info directly!"));
    }

    /**
     * @Route("/product/add")
     */
    public function addAction(Request $request)
    {
        $product = new product();

        $form = $this->createFormBuilder($product)
            //->add("product", TextType::class) //p.p 5.5+
            ->add("name", "Symfony\Component\Form\Extension\Core\Type\TextType",
                array("label" => "Product name: ", "attr" => array("maxlength" => 30)))
            ->add("description", "Symfony\Component\Form\Extension\Core\Type\TextType",
                array("label" => "Product description: ", "attr" => array("maxlength" => 100)))
            ->add("price", "Symfony\Component\Form\Extension\Core\Type\NumberType",
                array("label" => "Product price: ", "scale" => 2, "attr" => array("maxlength" => 10)))
            ->add("save", "Symfony\Component\Form\Extension\Core\Type\SubmitType",
                array("label" => "Create one product"))
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product = new Product();
            $product->setName($form->get("name")->getData());
            $product->setPrice($form->get("price")->getData());
            $product->setDescription($form->get("description")->getData());

            // fetches Doctrine's entity manager object,
            // which is responsible for the process of persisting objects to,
            // and fetching objects from, the database.
            $entityManager = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($product);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->render("larry/product/add.html.twig",
                array("form" => $form->createView(), "msg"=>"Product Id=". $product->getId()." has been added successfully!"));

        }

        return $this->render("larry/product/add.html.twig",
            array("form" => $form->createView(), "msg"=>"Please enter the product info to add product!"));

    }

    /**
     * @Route("/product/delete/{productId}")
     */
    public function deleteByIDAction($productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute("list");

    }

    /**
     * @Route("/product/search")
     */
    public function SearchAction()
    {
        $search_id = $_POST["product_id"];
        $search_name = $_POST["name"];
        $search_description = $_POST["description"];
        $search_operation = $_POST["operation"];
        $search_price = $_POST["price"];

        $entityManager = $this->getDoctrine()->getRepository(Product::class);

        if ($search_price !=null){
            $SQL = 'p.price'.$search_operation.$search_price;
        }

        if ($search_id !=null) {
            $SQL .= 'and p.id =' . $search_id;
        }

        if ($search_name !=null){
            $SQL .= "and p.name like '%$search_name%'";

        }
        if ($search_description!=null){
            $SQL .= "and p.description like '%$search_description%'";
        }

        $query = $entityManager->createQueryBuilder('p')
            ->where($SQL)
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        $products = $query->getResult();

        return $this->render("larry/product/list.html.twig",
            array("products" => $products, "msg" => "All matched products have been list here:"));
    }

    /**
    * @Route("/product/sort/price_down")
    */
    public function SortByPriceDESAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT p
    FROM LarryBundle:Product p
    ORDER BY p.price DESC'
        );

        $products = $query->getResult();

        return $this->render("larry/product/list.html.twig",
            array("products" => $products, "msg" => "All products have been list here:"));
    }

    /**
     * @Route("/product/sort/price_up")
     */
    public function SortByPriceASCAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT p
    FROM LarryBundle:Product p
    ORDER BY p.price ASC'
        );

        $products = $query->getResult();

        return $this->render("larry/product/list.html.twig",
            array("products" => $products, "msg" => "All products have been list here:"));
    }

    /**
     * @Route("/product/sort/id_down")
     */
    public function SortByIdDESCAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT p
    FROM LarryBundle:Product p
    ORDER BY p.id DESC'
        );

        $products = $query->getResult();

        return $this->render("larry/product/list.html.twig",
            array("products" => $products, "msg" => "All products have been list here:"));
    }

    /**
     * @Route("/product/sort/id_up")
     */
    public function SortByIdASCAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT p
    FROM LarryBundle:Product p
    ORDER BY p.id ASC'
        );

        $products = $query->getResult();

        return $this->render("larry/product/list.html.twig",
            array("products" => $products, "msg" => "All products have been list here:"));
    }

    /**
     * @Route("/product/sort/name_up")
     */
    public function SortByNameASCAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT p
    FROM LarryBundle:Product p
    ORDER BY p.name ASC'
        );

        $products = $query->getResult();

        return $this->render("larry/product/list.html.twig",
            array("products" => $products, "msg" => "All products have been list here:"));
    }
}