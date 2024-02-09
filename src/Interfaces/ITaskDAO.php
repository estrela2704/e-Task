<?php
namespace etask\Interfaces;
use etask\Models\Task;

interface ITaskDAO
{
    public function __construct();
    public function buildTask($taskData);
    public function create(Task $task);
    public function update(Task $task);
    public function delete(Task $task);
    public function findById($id);
    public function findAllByUserID($userID);
    public function concludeTask(Task $task);

}