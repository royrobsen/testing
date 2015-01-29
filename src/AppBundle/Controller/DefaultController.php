<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{   
    /**
     * @Route("/app/create", name="create")
     */
    
    public function createAction()
    {
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($product);
        $em->flush();
        
        return new Response('Created product id ' . $product->getId());
    }  
    
    /**
     * @Route("/", name="homepage")
     */

     public function indexAction()
     {
        return new Response('Homepage');
     }
     
    /**
     * @Route("/app/show/{id}", name="show")
     */
     
     public function showAction($id)
     {
         $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->find($id);
            
        if ( !$product ) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id );
        }
        
        return new Response('Ich habe das Produkt "' . $product->getName() . '" gefunden!');
        
     }
     
    /**
     * @Route("/app/update/{id}", name="update")
     */
    
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);
        
        if ( !$product ) {
            throw $this->createNotFoundException(
                'No product found for id '. $id );
        }
        
        $product->setName('Neues Produkt!' . rand(1, 1000) );
        $em->flush();
        
        return $this->redirect($this->generateUrl('homepage'));
    }
    
  /**
    * @Route("/app/showall", name="showall")
    */
    
    public function showallAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Product');
            
        $query = $repository->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', '19.99')
            ->orderBy('p.price', 'ASC')
            ->getQuery();
    
        $products = $query->getResult();

    }
    
    /**
    * @Route("/app/createprocat", name="createCat")
    */
    
    public function createProductAction ()
    {
        $category = new Category();
        $category->setName('Main Products');
        
        $product = new Product();
        $product->setName('Produktname');
        $product->setPrice('29.99');
        $product->setDescription('Lorem ipsum dolor');
        // relate this product to the category
        $product->setCategory($category);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);
        $em->flush();
        
        return new Response(
            'Created product id: ' . $product->getId()
            . ' and category id: ' . $category->getId()
        );
    }
     
}
