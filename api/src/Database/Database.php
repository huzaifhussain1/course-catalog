<?php
namespace Src\Database;

class Database {
    private $host = DB_HOST;
    private $dbName = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASSWORD;
    private $conn;

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new \PDO(
                    "mysql:host={$this->host};dbname={$this->dbName}",
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}
