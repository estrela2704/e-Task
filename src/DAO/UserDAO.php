<?php
namespace etask\DAO;

use etask\Models\User;
use etask\Interfaces\IUserDAO;

class UserDAO implements IUserDAO
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function buildUser($userDATA)
    {

        $user = new User($userDATA['name'], $userDATA['lastname'], $userDATA['email'], $userDATA['password'], $userDATA['token']);

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
        $stmt = $this->conn->prepare('INSERT INTO users(name, lastname, email, password, token) VALUES (:name, :lastname, :email, :password, :token)');
        $stmt->bindValue(':name', $user->getName());
        $stmt->bindValue(':lastname', $user->getLastname());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':token', $user->getToken());

        $stmt->execute();

        $user->setId($this->conn->lastInsertId());

    }
    public function update(User $user)
    {
        $stmt = $this->conn->prepare('UPDATE users SET name = :name, lastname = :lastname, image = :image WHERE id =:id');

        $stmt->bindValue(':name', $user->getName());
        $stmt->bindValue(':lastname', $user->getLastname());
        $stmt->bindValue(':image', $user->getImage());
        $stmt->bindValue(':id', $user->getId());

        $stmt->execute();
    }
    public function findById($id)
    {
        if ($id) {
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

        } else {
            return false;
        }

    }
    public function findByEmail($email)
    {
        if ($email) {
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

        } else {
            return false;
        }
    }
    public function findByToken($token)
    {
        if ($token) {
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

        } else {
            return false;
        }
    }
}

