<?php


use CoffeeCode\Router\Router;

$router = new Router(BASE_URL);

$router->namespace("Etask\Controllers");

$router->group(null);
//MÉTODOS GET DA PAGINA PADRÃO
$router->get('/', "WebController:index");
$router->get('/login', "AuthController:login");
$router->get('/register', "AuthController:register");
$router->get('/logout', "AuthController:logout");
//MÉTODOS POST DA PAGINA PADRÃO
$router->post('/login', "AuthController:loginAction");
$router->post('/register', "AuthController:registerAction");

$router->group('home');
$router->get('/', "UserController:index"); 
$router->post('/', "UserController:getTaskOrder"); 
$router->group('task');
//METODOS GET
$router->get('/add', "TaskController:addTask");
$router->get('/view/{id}', "TaskController:viewTask");
$router->get('/edit/{id}', "TaskController:updateTask");
$router->get('/delete/{id}', "TaskController:deleteTaskAction");
$router->get('/conclude/{id}', "TaskController:concludeTaskAction");
$router->get('/search', "UserController:index");
//METODOS POST 
$router->post('/add', "TaskController:addTaskAction");
$router->post('/search', "TaskController:searchTaskAction");
$router->post('/edit/{id}', "TaskController:updateTaskAction");


$router->dispatch();

if ($router->error()) {
    echo $router->error();
}
