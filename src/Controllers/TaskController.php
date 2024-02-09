<?php

namespace Etask\Controllers;
use Etask\DAO\UserDAO;
use Etask\DAO\TaskDAO;
use Etask\Services\TaskService;
use Etask\Utils\View;
use Etask\Services\AuthService;
use Exception;
class TaskController {

    private $authService;
    private $userDAO;
    private $taskDAO;
    private $auth;
    private $taskService;

    public function __construct(){
        $this->authService = new AuthService();
        $this->userDAO = new UserDAO();
        $this->taskDAO = new TaskDAO();
        $this->taskService = new TaskService();
        $this->auth = $this->authService->verifyToken();
        $this->verifyAuth();
    }
    private function validateData(){
            $fieldTranslations = [
                'name' => 'nome',
                'description' => 'descrição',
                'urgent' => '"Urgente"'
            ];

            $requiredFields = array_keys($fieldTranslations);
            foreach ($requiredFields as $field) {
                $translatedField = $fieldTranslations[$field];
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    $errorMessage = "Por favor, preencha o campo $translatedField";
                    throw new Exception($errorMessage);
                }
            }
        return true;
    }

    private function verifyAuth(){
        if($this->auth === false){
            $data = [
                "type" => "error",
                "msg" => "Por favor, se autentique para continuar!"
            ];
            echo View::render("/Auth/login", $data);
            exit;
        }
    }

    public function viewTask($id){
        $user = $this->userDAO->findByToken($_SESSION['token']);
        $task = $this->taskService->AuthorizeAction($user, $id['id']);
        $data = [
            "user" => $user,
            "task" => $task
        ];
        echo View::render("/Tasks/task", $data);
    }

    public function addTask(){
        $user = $this->userDAO->findByToken($_SESSION['token']);
        $data = [
            "user" => $user
        ];
        echo View::render("/Tasks/addTask", $data);
        
    }

    public function updateTask($id){
        $user = $this->userDAO->findByToken($_SESSION['token']);
        $task = $this->taskService->AuthorizeAction($user, $id['id']);
        if($user->getId() === $task->getUserId()){
            $data = [
                "user" => $user,
                "task" => $task
            ];
            echo View::render("/Tasks/updateTask", $data);
        } else {
            header("Location: /to-do/home");
            exit;
        }
         
    }

    public function addTaskAction(){
        try {
            $token = $_SESSION['token'];
            $user = $this->userDAO->findByToken($token);
            $this->validateData();
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $urgent = filter_input(INPUT_POST, 'urgent', FILTER_SANITIZE_STRING);
            $taskData = 
            [
                "name" => $name,
                "description" => $description,
                "urgent" => $urgent,
                "Users_id" => $user->getId()
            ];
            $task = $this->taskDAO->buildTask($taskData);
            $this->taskDAO->create($task);
            header("Location: /to-do/home");
        } catch (Exception $e) {
            $data = [
                "user" => $user,
                "type" => 'error',
                "msg" => $e->getMessage()
            ];
            echo View::render("/Tasks/addTask", $data);
        }
    }

    public function updateTaskAction($id){
        try{
            $user = $this->userDAO->findByToken($_SESSION['token']);
            $task = $this->taskService->AuthorizeAction($user, $id['id']);
            $this->validateData();
            
            $newName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $newDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $newUrgent = filter_input(INPUT_POST, 'urgent', FILTER_SANITIZE_STRING);

            $task->setName($newName);
            $task->setDescription($newDescription);
            $task->setUrgent($newUrgent);

            $this->taskDAO->update($task);
            $data = [
                "user" => $user,
                "task" => $task,
                "type" => "success",
                "msg" => "Tarefa atualizada!"
            ];
            echo View::render("/Tasks/updateTask", $data);
        } catch (Exception $e){
            $data = [
                "type" => 'error',
                "msg" => $e->getMessage()
            ];
            echo View::render("/Tasks/updateTask", $data);
        }
        
    }

    public function deleteTaskAction($id){
        try{
            $user = $this->userDAO->findByToken($_SESSION['token']);
            $task = $this->taskService->AuthorizeAction($user, $id['id']);
                
            $this->taskDAO->delete($task);

            header("Location: /to-do/home");
            exit;
        } catch (Exception $e){
            $data = [
                "type" => 'error',
                "msg" => $e->getMessage()
            ];
            echo View::render("/Tasks/updateTask", $data);
        }
        
    }

    public function concludeTaskAction($id) {     
        try{
            $user = $this->userDAO->findByToken($_SESSION['token']);
            $task = $this->taskService->AuthorizeAction($user, $id['id']);
            
            $task->setStatus('concluida');
            $this->taskDAO->concludeTask($task);

            header("Location: /to-do/home");
            exit;
        } catch(Exception $e){
            $data = [
                "type" => 'error',
                "msg" => $e->getMessage()
            ];
            echo View::render("/Tasks/updateTask", $data);
        }
    }

    public function searchTaskAction() {     
        try{
            $name = $_POST['search'];
            $user = $this->userDAO->findByToken($_SESSION['token']);
            $task = $this->taskDAO->findByNameAndUsersId($name, $user->getId());

            $data = [
                "search" => true,
                "user" => $user,
                "tasks" => $task
            ];

            echo View::render("/Tasks/index", $data);
        } catch(Exception $e){
            $data = [
                "type" => 'error',
                "msg" => $e->getMessage()
            ];
            echo View::render("/Tasks/updateTask", $data);
        }
    }
    
}