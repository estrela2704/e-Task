<?php

namespace Etask\Controllers;

use Etask\Utils\View;
use Etask\Services\AuthService;

class WebController
{
    private $authService;
    private $auth;

    public function __construct(){
        $this->authService = new AuthService();
        $this->auth = $this->authService->verifyToken();
    }
    public function index()
    {         
        if($this->auth) {
            header("Location: /to-do/home");
        } else {
            echo View::render("home");
        }
    }
}