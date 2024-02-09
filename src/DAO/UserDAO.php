<?php
namespace Etask\DAO;

use Etask\Models\User;
use Etask\Interfaces\IUserDAO;
use Etask\Database\ConnectionManager;
use Exception;

class UserDAO implements IUserDAO
{
    private $conn;

    public function __construct()
    {
        $driver = new ConnectionManager();
        $this->conn = $driver->getConnection();
    }

    public function buildUser($userDATA)
    {
        $user = new User($userDATA['name'], $userDATA['lastname'], $userDATA['email']);
        $user->setPassword($userDATA['password']);
        $user->setToken($userDATA['token']);

        if (isset($userDATA['id'])) {
            $user->setId($userDATA['id']);
        }

        if (isset($userDATA['image'])) {
            $user->setImage($userDATA['image']);
        }

        return $user;
    }

    public function create(User $user)
    {
        try {
            $stmt = $this->conn->prepare('INSERT INTO users(name, lastname, email, password, token) VALUES (:name, :lastname, :email, :password, :token)');
            $stmt->bindValue(':name', $user->getName());
            $stmt->bindValue(':lastname', $user->getLastname());
            $stmt->bindValue(':email', $user->getEmail());
            $stmt->bindValue(':password', $user->getPassword());
            $stmt->bindValue(':token', $user->getToken());

            $stmt->execute();

            $user->setId($this->conn->lastInsertId());

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function update(User $user)
    {
        try {
            $stmt = $this->conn->prepare('UPDATE users SET name = :name, lastname = :lastname, image = :image, token = :token WHERE id =:id');

            $stmt->bindValue(':name', $user->getName());
            $stmt->bindValue(':lastname', $user->getLastname());
            $stmt->bindValue(':image', $user->getImage());
            $stmt->bindValue(':id', $user->getId());
            $stmt->bindValue(':token', $user->getToken());

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function findById($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM users WHERE id = :id');

            $stmt->bindValue(':id', $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function findByEmail($email)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM users WHERE email = :email');

            $stmt->bindValue(':email', $email);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function findByToken($token)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM users WHERE token = :token');

            $stmt->bindValue(':token', $token);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

