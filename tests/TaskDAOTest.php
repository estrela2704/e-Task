<?php


require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Etask\DAO\TaskDAO;
use Etask\Models\Task;

class TeskDAOTest extends TestCase
{
    private $taskDAO;

    protected function setUp(): void
    {
        // Configurações iniciais, incluindo injeção de dependência
        $this->taskDAO = new TaskDAO;
    }
    public function testTaskCreate()
    {
        // Configuração de teste

        $taskData = [
            'name' => 'teste',
            'description' => 'teste',
            'status' => 'concluida',
            'urgent' => 'não',
            'Users_id' => 44
        ];

        $task = $this->taskDAO->buildTask($taskData);

        print_r($task);

        $this->taskDAO->create($task);

        $this->assertGreaterThan(0, $task->getUserId(), 'O ID do usuário deve ser maior que zero após a criação.');
    }

    public function testTaskFindByID()
    {
        $task = $this->taskDAO->findById(5);
        $this->assertEquals(5, $task->getId(), 'O id deve ser igual a 5.');
    }

    public function testTaskFindByStatusAndUsersId()
    {
        $task = $this->taskDAO->findByStatusAndUsersId('em_andamento', 44);
        $this->assertEquals(5, $task->getId(), 'O id deve ser igual a 5');
    }

    
    public function testTaskFindByNameAndUsersId()
    {
        $task = $this->taskDAO->findByNameAndUsersId('Jo', 44);
        $this->assertEquals(5, $task->getId(), 'O id deve ser igual a 5.');
    }

    public function testTaskUpdate()
    {

        $newName = "Johan";
        $newDescription = "Estrela";
        $newStatus = "em_andamento";

        $task = $this->taskDAO->findById(5);
        $task->setName($newName);
        $task->setDescription($newDescription);
        $task->setStatus($newStatus);

        $this->taskDAO->update($task);

        $task = $this->taskDAO->findById(5);

        $this->assertEquals("Johan", $task->getName(), 'O nome do usuário deve ser Johan após a execução do teste.');
    }

}
