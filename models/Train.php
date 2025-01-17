<?php
require_once "db.php";

class Train
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    // Récupérer tous les trains
    public function getAllTrains()
    {
        $stmt = $this->pdo->query("SELECT * FROM trains");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un train
    public function addTrain($name)
    {
        $stmt = $this->pdo->prepare("INSERT INTO trains (name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    // Mettre à jour le nom d'un train (Correction)
    public function updateTrainName($id, $name)
    {
        $stmt = $this->pdo->prepare("UPDATE trains SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    // Mettre à jour le statut d'un train
    public function updateTrainStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE trains SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // Supprimer un train
    public function deleteTrain($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM trains WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
