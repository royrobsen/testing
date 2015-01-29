<?php

    namespace AppBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


    class HelloController extends Controller
    {

      /**
        * @Route("/hello/{name}", name="hello")
        */

        public function indexAction( $name )
        {
            
            $session = $request->getSession();
            
            // store an attribute for reuse during a later user request
            $session->set('foo', 'bar');
            
            // get the attribute set by another controller in another request
            
        }
        
      /**
        *   @Route("/blog/{slug}") 
        */
        
        public function showAction ( $slug )
        {
             return "tet";
        }
        
    }



?>