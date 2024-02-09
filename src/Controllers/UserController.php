<?php

namespace Etask\Controllers;

use Etask\DAO\UserDAO;
use Etask\DAO\TaskDAO;
use Etask\Utils\View;
use Etask\Services\AuthService;
use Exception;
class UserController 
{
    private $authService;
    private $userDAO;
    private $taskDAO;

    public function __construct(){
        $this->authService = new AuthService();
        $this->userDAO = new UserDAO();
        $this->taskDAO = new TaskDAO();
        $this->verifyAuth();
    }

    private function verifyAuth(){
        if($this->authService->verifyToken() === false){
            $data = [
                "type" => "error",
                "msg" => "Por favor, se autentique para continuar!"
            ];
            echo View::render("/Auth/login", $data);
            exit;
        }
    }
    public function index(){
            $user = $this->userDAO->findByToken($_SESSION['token']);
            $tasks = $this->taskDAO->findAllByUserID($user->getId());
            $data = [
                "user" => $user,
                "tasks" => $tasks
            ];
            echo View::render("/Tasks/index", $data);
    }

    public function getTaskOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
            $order = $_POST['order'];
            $user = $this->userDAO->findByToken($_SESSION['token']);
            $tasks = $this->taskDAO->getTasksSorted($user->getId(), $order);

            $data = [
                "user" => $user,
                "tasks" => $tasks
            ];
            echo View::render("/Tasks/index", $data);
        } else {
            print_r($_POST);exit;
        }
    }

}