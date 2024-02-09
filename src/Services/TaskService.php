<?php

namespace Etask\Services;

use Etask\DAO\TaskDAO;
use Exception;
use Etask\DAO\UserDAO;

class TaskService
{

    private $taskDAO;
    private $userDAO;

    public function __construct()
    {
        $this->taskDAO = new TaskDAO();
        $this->userDAO = new UserDAO();
    }

    public function AuthorizeAction($User, $id){
        $user = $User;
        $task = $this->taskDAO->findById($id);
        if($user->getId() === $task->getUserId()){
            return $task;
        } else {
            header("Location: /to-do/home");
            exit;  
        }
    }

}
