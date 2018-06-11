<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/17
 * Time: 4:54 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

//class LuckController{
//    /**
//     * @Route("/lucky/number")
//     */
//    public function numberAction(){
//        $number = mt_rand(1,100);
//
//        return new Response(
//            '<html><body>Lucky number is: '.$number.'</body></html>'
//        );
//    }
//}

class LuckController extends Controller{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = mt_rand(1, 100);

        return $this->render('lucky/number.html.twig', array(
            'number' => $number,)
    );
    }
}
