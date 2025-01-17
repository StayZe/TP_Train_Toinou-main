<?php
require_once __DIR__ . "/../controllers/TrainController.php";

header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];
$request_uri = str_replace("/api", "", explode("?", $_SERVER["REQUEST_URI"])[0]);

$trainController = new TrainController();

// ✅ Gestion des requêtes GET (affichage)
if ($method === "GET") {
    if ($request_uri === "/trains") {
        $trainController->getTrains();
    } elseif ($request_uri === "/repair-types") {
        $trainController->getRepairTypes();
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
    }
    exit;
}

// ✅ Gestion des requêtes POST (ajout)
if ($method === "POST") {
    if ($request_uri === "/trains") {
        $trainController->addTrain();
    } elseif ($request_uri === "/repair-types") {
        $trainController->addRepairType();
    } elseif ($request_uri === "/train-repairs") {
        $trainController->addTrainRepair();
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
    }
    exit;
}

// ✅ Gestion des requêtes DELETE (suppression)
if ($method === "DELETE") {
    if ($request_uri === "/trains") {
        $trainController->deleteTrain();
    } elseif ($request_uri === "/train-repairs") {
        $trainController->deleteTrainRepair();
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
    }
    exit;
}

// ❌ Si la méthode HTTP n'est pas supportée
http_response_code(405);
echo json_encode(["error" => "Méthode non autorisée"]);
