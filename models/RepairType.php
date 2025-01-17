<?php
require_once "db.php";

class RepairType
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function getAllRepairTypes()
    {
        $stmt = $this->pdo->query("SELECT * FROM repair_types");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addRepairType($name)
    {
        $stmt = $this->pdo->prepare("INSERT INTO repair_types (name) VALUES (?)");
        return $stmt->execute([$name]);
    }
}
