<?php

namespace Etask\Controllers;

use Etask\Utils\View;
use Etask\Services\AuthService;
use Exception;

class AuthController 
{
    private $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    private function validateData($type)
    {
        if ($type === "login") {
            $fieldTranslations = [
                'email' => 'e-mail',
                'password' => 'senha',
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
        } else if ($type == "register") {
            $fieldTranslations = [
                'name' => 'nome',
                'lastname' => 'sobrenome',
                'email' => 'e-mail',
                'password' => 'senha',
                'confirmpassword' => 'confirmação de Senha',
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
    }
    public function login()
    {
        echo View::render("/Auth/login");
    }

    public function register()
    {
        echo View::render("/Auth/register");
    }

    public function logout(){
        session_unset();
        session_destroy();
    
         // Redireciona para a página de login
        header("Location: /to-do/");
        exit;
    }

    public function loginAction()
    {
        try {
            $this->validateData('login');
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $this->authService->authenticateUser($email, $password);
            header("Location: /to-do/home");
            exit;
        } catch (Exception $e) {
            $data = [
                "type" => 'error',
                "msg" => $e->getMessage()
            ];
            echo View::render("/Auth/login", $data);
        }
    }
    public function registerAction()
    {
        try {
            $this->validateData('register');

            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_STRING);

            if ($password !== $confirmpassword) {
                throw new Exception("Senhas não coincidem!");
            }
            $this->authService->registerUser($name, $lastname, $email, $password);
            header("Location: /to-do/home");
            exit;
        } catch (Exception $e) {
            $data = [
                "type" => 'error',
                "msg" => $e->getMessage()
            ];
            echo View::render("/Auth/register", $data);
        }
    }

}
