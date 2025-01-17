<?php
require_once "db.php";

class TrainRepair
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function addTrainRepair($train_id, $repair_type_id)
    {
        $stmt = $this->pdo->prepare("INSERT INTO train_repairs (train_id, repair_type_id) VALUES (?, ?)");
        return $stmt->execute([$train_id, $repair_type_id]);
    }

    public function getRepairsByTrainId($train_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM train_repairs WHERE train_id = ?");
        $stmt->execute([$train_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteTrainRepair($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM train_repairs WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
