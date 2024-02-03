<?php


require_once __DIR__ . '/../vendor/autoload.php';


use PHPUnit\Framework\TestCase;
use etask\DAO\UserDAO;
use etask\Database\ConnectionManager;

class UserDAOTest extends TestCase
{

    private $conn;

    public function setUp(): void
    {

        $driver = new ConnectionManager();

        $this->conn = $driver->getConnection(); // Inicialize sua conexão aqui
    }

    public function testCreate()
    {
        // Configuração de teste
        $userDAO = new UserDAO($this->conn);

        $userData = [
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'hashed_password',
            'token' => '12345',
        ];

        $user = $userDAO->buildUser($userData);

        $userDAO->create($user);

        $this->assertGreaterThan(0, $user->getId(), 'O ID do usuário deve ser maior que zero após a criação.');

    }

    public function testFindByID()
    {

        $userDAO = new UserDAO($this->conn);

        $id = 6;

        $user = $userDAO->findById($id);

        $this->assertEquals(6, $user->getId(), 'O id do usuário deve ser igual.');

    }

    public function testUpdate()
    {

        $userDAO = new UserDAO($this->conn);

        $newName = "Johan";
        $newLastname = "Estrela";
        $image = "teste";

        $user = $userDAO->findById(6);
        $user->setName($newName);
        $user->setLastname($newLastname);
        $user->setImage($image);

        $userDAO->update($user);

        $this->assertEquals("Johan", $user->getName(), 'O nome do usuário deve ser Johan após a execução do teste.');

    }

    public function testFindByEmail()
    {

        $userDAO = new UserDAO($this->conn);

        $email = "john.doe@example.com";

        $user = $userDAO->findByEmail($email);

        $this->assertEquals("john.doe@example.com", $user->getEmail(), 'O email do usuário deve ser igual.');
    }

    public function testFindByToken()
    {

        $userDAO = new UserDAO($this->conn);

        $token = "12345";

        $user = $userDAO->findByToken($token);

        $this->assertEquals("12345", $user->getToken(), 'O token do usuário deve ser igual.');

    }


}
