<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'manga_db';
    private $username = 'root';
    private $password = '';

    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed" . $this->conn->connect_error);
        }
    }

    public function connect()
    {
        return $this->conn;
    }

    public function close()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
