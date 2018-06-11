<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/25
 * Time: 9:37 PM
 */

namespace LarryBundle\Controller;

use LarryBundle\Form\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FormController extends Controller{
    /**
     * @Route("/form")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(new FormType());

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $password1 = $form->get("password1")->getData();
            $password2 = $form->get("password2")->getData();

            if($password1 != $password2){
                return $this->render("larry/form.html.twig",
                    array("pwd"=>"Password doesn't matched!","form"=>$form->createView()));
            }else {

                return $this->render("larry/form_success.html.twig",
                    array("form" => $form->getData()));
            }
        }

        return $this->render("larry/form.html.twig",
            array("pwd"=>"","form"=>$form->createView()));
    }
}