<?php


require_once __DIR__ . '/../vendor/autoload.php';


use PHPUnit\Framework\TestCase;
use Etask\DAO\UserDAO;
use Etask\Services\AuthService;

class UserDAOTest extends TestCase
{
    private $userDAO;
    private $authService;

    protected function setUp(): void
    {
        // Configurações iniciais, incluindo injeção de dependência
        $this->userDAO = new UserDAO;
        $this->authService = new AuthService;
    }
    public function testCreate()
    {
        // Configuração de teste
        $password = "123";
        $token = $this->authService->generateToken();
        $finalPasword = $this->authService->generatePassword($password);
        $userData = [
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'token' => $token,
            'password' => $finalPasword
        ];

        $user = $this->userDAO->buildUser($userData);

        $this->userDAO->create($user);

        $this->assertGreaterThan(0, $user->getId(), 'O ID do usuário deve ser maior que zero após a criação.');
    }

    public function testFindByID()
    {
        $id = 37;

        $user = $this->userDAO->findById($id);

        $this->assertEquals(37, $user->getId(), 'O id do usuário deve ser igual.');

    }

    public function testUpdate()
    {

        $newName = "Johan";
        $newLastname = "Estrela";
        $image = "teste";

        $user = $this->userDAO->findById(37);
        $user->setName($newName);
        $user->setLastname($newLastname);
        $user->setImage($image);

        $this->userDAO->update($user);

        $this->assertEquals("Johan", $user->getName(), 'O nome do usuário deve ser Johan após a execução do teste.');

    }

    public function testFindByEmail()
    {
        $email = "john.doe@example.com";

        $user = $this->userDAO->findByEmail($email);

        $this->assertEquals("john.doe@example.com", $user->getEmail(), 'O email do usuário deve ser igual.');
    }

    public function testFindByToken()
    {

        $token = "dcf938869077cd86f5c5cc8cd051ee4e3976a8048e412a47b8d42aa13bd66d734cf7a1aab9a68c0abd10cf0d4af649ddaa6c";

        $user = $this->userDAO->findByToken($token);

        $this->assertEquals("dcf938869077cd86f5c5cc8cd051ee4e3976a8048e412a47b8d42aa13bd66d734cf7a1aab9a68c0abd10cf0d4af649ddaa6c", $user->getToken(), 'O token do usuário deve ser igual.');
    }


}
