<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/28
 * Time: 9:37 PM
 */

namespace LarryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BaseController extends Controller{
    /**
     * @Route("/base")
     */
    public function newAction()
    {

        return $this->render("larry/base.html.twig");
    }

    /**
     * @Route("/tran")
     */
    public function TranAction()
    {
        $tran_ZH = "Symfony is great";
        $name = "larry";

        $en = $_REQUEST['locate'];

        if ($en == "zh"){
            $translated1 = $this->get('translator')->trans($tran_ZH, array(),null,"zh_CN");
//        $translated2 = $this->get('translator')->trans( 'Hello %name%', array('%name%' => $name));
            $translated2 = $this->get('translator')->trans( 'hello.%name%', array('%name%' => $name),null,"zh_CN");
            $translated3 = $this->get('translator')->trans('test.msg', array(),null,"zh_CN");
        }elseif ($en == "jp"){
            $translated1 = $this->get('translator')->trans($tran_ZH, array(),null,"jp");
            $translated2 = $this->get('translator')->trans( 'hello.%name%', array('%name%' => $name),null,"jp");
            $translated3 = $this->get('translator')->trans('test.msg', array(),null,"jp");
        }else{
            $translated1 = $this->get('translator')->trans($tran_ZH, array(),null,"en");
            $translated2 = $this->get('translator')->trans( 'hello.%name%', array('%name%' => $name),null,"en");
            $translated3 = $this->get('translator')->trans('test.msg', array(),null,"en");
        }

        return $this->render("/larry/tran.html.twig",
            array("translated1"=>$tran_ZH."=>".$translated1, "translated2"=>$translated2,
                "translated3"=>$translated3));
    }
}