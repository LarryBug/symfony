<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/25
 * Time: 4:40 PM
 */

namespace LarryBundle\Controller;

use LarryBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class TaskController extends Controller {
    /**
     * @Route("/task"), name="larry"
     */
    public function newTaskAction(Request $request){
        $task = new Task();

        $task->setTask("Enter a task name");

        $task->setDueDate(new \DateTime("tomorrow"));

        $form = $this->createFormBuilder($task)
            //->add("task", TextType::class) //p.p 5.5+
            ->add("task","Symfony\Component\Form\Extension\Core\Type\TextType",
                array("label"=>"Task: ", "attr" => array("maxlength" => 5)))
            ->add("dueDate","Symfony\Component\Form\Extension\Core\Type\DateType",
                array("widget" => "single_text", "label"=>"Due Date: "))
            ->add("save","Symfony\Component\Form\Extension\Core\Type\SubmitType",
                array("label"=>"Create Task"))
            ->getForm();


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $task = $form->getData();

            return $this->render("larry/task_success.html.twig",
                array("task"=>$task->getTask(),"date"=>$task->getDueDate()->format("Y-m-d")));
        }

        return $this->render("larry/task.html.twig",
            array("form"=>$form->createView()));
    }

}