<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/25
 * Time: 4:36 PM
 */

namespace LarryBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Task{

    /**
     * @Assert\NotBlank()
     */
    protected $task;


    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    protected $dueDate;


    public function getTask()
    {
        return $this->task;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }
}