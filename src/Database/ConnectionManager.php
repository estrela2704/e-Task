<?php

namespace etask\Database;

use Dotenv\Dotenv;

class ConnectionManager
{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();

        $this->db_host = $_ENV['DB_HOST'];
        $this->db_user = $_ENV['DB_USER'];
        $this->db_pass = $_ENV['DB_PASS'];
        $this->db_name = $_ENV['DB_NAME'];
    }
    public function getConnection()
    {

        $conn = new \PDO("mysql:dbname=" . $this->db_name . ";host=" . $this->db_host, $this->db_user, $this->db_pass);

        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

        return $conn;
    }
}