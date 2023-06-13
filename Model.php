<?php
require_once 'config.php';

class Model
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=" . $GLOBALS['dbHost'] . ";dbname=" . $GLOBALS['dbName'], $GLOBALS['dbUser'], $GLOBALS['dbPassword']);
    }

    public function saveFormData($content)
    {
        $stmt = $this->conn->prepare("INSERT INTO form_data (content) VALUES (?)");
        $stmt->execute([$content]);
        return $this->conn->lastInsertId();
    }

    public function getFormData($id)
    {
        $stmt = $this->conn->prepare("SELECT content FROM form_data WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
}
