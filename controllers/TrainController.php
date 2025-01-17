<?php
require_once __DIR__ . "/../models/Train.php";
require_once __DIR__ . "/../models/RepairType.php";
require_once __DIR__ . "/../models/TrainRepair.php";

class TrainController
{
    private $train;
    private $repairType;
    private $trainRepair;

    public function __construct()
    {
        $this->train = new Train();
        $this->repairType = new RepairType();
        $this->trainRepair = new TrainRepair();
    }

    public function getTrains()
    {
        return json_encode($this->train->getAllTrains()); // ✅ Maintenant, la fonction retourne le JSON
    }

    public function addTrain()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["name"])) {
            http_response_code(400);
            echo json_encode(["error" => "Nom du train manquant"]);
            return;
        }
        $this->train->addTrain($data["name"]);
        echo json_encode(["message" => "Train ajouté", "status" => "En service"]);
    }

    public function updateTrain()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["id"], $data["name"])) {
            http_response_code(400);
            echo json_encode(["error" => "ID ou nom manquant"]);
            return;
        }
        $this->train->updateTrainName($data["id"], $data["name"]);
        echo json_encode(["message" => "Nom du train mis à jour"]);
    }

    public function deleteTrain()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["id"])) {
            http_response_code(400);
            echo json_encode(["error" => "ID manquant"]);
            return;
        }
        $this->train->deleteTrain($data["id"]);
        echo json_encode(["message" => "Train supprimé"]);
    }

    public function updateTrainStatus()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["id"], $data["status"])) {
            http_response_code(400);
            echo json_encode(["error" => "ID ou statut manquant"]);
            return;
        }

        if ($this->train->updateTrainStatus($data["id"], $data["status"])) {
            echo json_encode(["message" => "Statut du train mis à jour"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Statut invalide"]);
        }
    }

    // Gérer les types de réparations
    public function getRepairTypes()
    {
        return json_encode($this->repairType->getAllRepairTypes()); // ✅ Maintenant, ça retourne bien une string
    }

    public function addRepairType()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["name"])) {
            http_response_code(400);
            echo json_encode(["error" => "Nom du type de réparation manquant"]);
            return;
        }
        $this->repairType->addRepairType($data["name"]);
        echo json_encode(["message" => "Type de réparation ajouté"]);
    }

    // Ajouter une réparation (association train - réparation)
    public function addTrainRepair()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["train_id"], $data["repair_type_id"])) {
            http_response_code(400);
            echo json_encode(["error" => "Données incomplètes"]);
            return;
        }
        $this->trainRepair->addTrainRepair($data["train_id"], $data["repair_type_id"]);
        echo json_encode(["message" => "Réparation enregistrée pour ce train"]);
    }

    // Récupérer toutes les réparations d'un train donné
    public function getRepairsForTrain($train_id)
    {
        echo json_encode($this->trainRepair->getRepairsByTrainId($train_id));
    }

    // Supprimer une réparation spécifique d'un train
    public function deleteTrainRepair()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["id"])) {
            http_response_code(400);
            echo json_encode(["error" => "ID manquant"]);
            return;
        }
        $this->trainRepair->deleteTrainRepair($data["id"]);
        echo json_encode(["message" => "Réparation supprimée"]);
    }
}
