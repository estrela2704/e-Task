<?php

namespace Etask\Services;

use Etask\DAO\UserDAO;
use Exception;

class AuthService
{

    private $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    public function setTokenToSession($token, $redirect = true)
    {
        $_SESSION['token'] = $token;

        if ($redirect) {
            return true;
        } else {
            return false;
        }

    }

    public function verifyToken()
    {
        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];
            $user = $this->userDAO->findByToken($token);
            if ($user) {
                return true;
            } else {
                return false;
            }
        } else {    
            return false;
        }
    }

    public function registerUser($name, $lastname, $email, $password)
    {
        $userExists = $this->userDAO->findByEmail($email);
        if ($userExists) {
            throw new Exception('Já existe um usuário cadastrado com esse e-mail!');
        }

        $finalPassword = $this->generatePassword($password);
        $token = $this->generateToken();
        $userData = [
            "name" => $name,
            "lastname" => $lastname,
            "email" => $email,
            "password" => $finalPassword,
            "token" => $token
        ];

        $user = $this->userDAO->buildUser($userData);

        try {
            $this->userDAO->create($user);
            $this->setTokenToSession($token);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function authenticateUser($email, $password)
    {
        $user = $this->userDAO->findByEmail($email);
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $token = $this->generateToken();
                $this->setTokenToSession($token);
                $user->setToken($token);
                $this->userDAO->update($user);

                return true;
            } else {
                throw new Exception("Usuário ou senha incorretos!");
            }
        } else {
            throw new Exception("Nenhum usuário encontrado com este e-mail!");
        }
    }

    public function generatePassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function generateToken()
    {
        return bin2hex(random_bytes(50));

    }

}