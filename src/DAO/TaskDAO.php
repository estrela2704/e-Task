<?php
namespace Etask\DAO;

use Etask\Models\Task;
use Etask\Interfaces\ITaskDAO;
use Etask\Database\ConnectionManager;
use Exception;

class TaskDAO implements ITaskDAO
{
    private $conn;

    public function __construct()
    {
        $driver = new ConnectionManager();
        $this->conn = $driver->getConnection();
    }

    public function buildTask($taskData)
    {
        $task = new Task($taskData['name'], $taskData['description'], $taskData['urgent'], $taskData['Users_id']);

        if (isset($taskData['id'])) {
            $task->setId($taskData['id']);
        }
        if (isset($taskData['status'])) {
            $task->setStatus($taskData['status']);
        }

        return $task;
    }
    public function create(Task $task){
        try {
            $stmt = $this->conn->prepare('INSERT INTO tasks(name, description, status, urgent, Users_id) VALUES (:name, :description, :status, :urgent, :userid)');
            $stmt->bindValue(':name', $task->getName());
            $stmt->bindValue(':description', $task->getDescription());
            $stmt->bindValue(':status', 'em_andamento');
            $stmt->bindValue(':urgent', $task->getUrgent());
            $stmt->bindValue(':userid', $task->getUserId());
            
            $stmt->execute();

            $task->setId($this->conn->lastInsertId());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function update(Task $task){
        try {
            $stmt = $this->conn->prepare('UPDATE tasks  set name = :name, description = :description, status = :status, urgent = :urgent WHERE id = :id');
            $stmt->bindValue(':name', $task->getName());
            $stmt->bindValue(':description', $task->getDescription());
            $stmt->bindValue(':status', $task->getStatus());
            $stmt->bindValue(':urgent', $task->getUrgent());
            $stmt->bindValue(':id', $task->getId());

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete(Task $task){
        try {
            $stmt = $this->conn->prepare('DELETE FROM tasks WHERE id = :id');
            $stmt->bindValue(':id', $task->getId());

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function findById($id){
        try {
            $stmt = $this->conn->prepare('SELECT * FROM tasks WHERE id = :id');

            $stmt->bindValue(':id', $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $task = $this->buildTask($data);

                return $task;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function findByStatusAndUsersId($status, $userId){
        try {
            $stmt = $this->conn->prepare('SELECT * FROM tasks WHERE status = :status AND Users_id = :id');

            $stmt->bindValue(':status', $status);
            $stmt->bindValue(':id', $userId);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $task = $this->buildTask($data);

                return $task;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function findByNameAndUsersId($name, $userId){
        try {
            $tasks = [];
            $finalName = "%".$name."%";
            $stmt = $this->conn->prepare('SELECT * FROM tasks WHERE name LIKE :name AND Users_id = :id');

            $stmt->bindValue(':name', $finalName);
            $stmt->bindValue(':id', $userId);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $taskArray = $stmt->fetchAll();
                foreach($taskArray as $task){
                    $tasks[] = $this->buildTask($task);
                }
            };

            return $tasks;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function findAllByUserID($userId){
        try {
            $tasks = [];
            $stmt = $this->conn->prepare('SELECT * FROM tasks WHERE Users_id = :id ORDER BY status');

            $stmt->bindValue(':id', $userId);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $tasksArray = $stmt->fetchAll();
                foreach($tasksArray as $task){
                    $tasks[] = $this->buildTask($task);
                }
            }

            return $tasks;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getTasksSorted($userId, $orderBy)
    {
        try {
            if($orderBy === 'recentes'){
                $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE Users_id = :id ORDER BY id ASC");
            } else if($orderBy === 'antigos'){
                $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE Users_id = :id ORDER BY id DESC");
            } else if($orderBy === 'urgencia'){
                $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE Users_id = :id AND Status != 'concluida' ORDER BY urgent DESC");
            }
            $tasks = [];
            $stmt->bindValue(':id', $userId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $tasksArray = $stmt->fetchAll();
                foreach($tasksArray as $task){
                    $tasks[] = $this->buildTask($task);
                }
            }

            return $tasks;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function concludeTask(Task $task){
        try {
            $stmt = $this->conn->prepare('UPDATE tasks set status = :status WHERE id = :id');
            $stmt->bindValue(':status', $task->getStatus());
            $stmt->bindValue(':id', $task->getId());

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}

