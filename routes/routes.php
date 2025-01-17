<?php
require_once __DIR__ . "/../controllers/UserController.php";
require_once __DIR__ . "/../controllers/TrainController.php";

header("Content-Type: application/json");

$request_uri = str_replace("/api", "", explode("?", $_SERVER["REQUEST_URI"])[0]);
$method = $_SERVER["REQUEST_METHOD"];

$userController = new UserController();
$trainController = new TrainController();

// ✅ Liste des routes API
$routes = [
    "GET" => [
        "/users" => [$userController, "getUsers"],
        "/trains" => [$trainController, "getTrains"],
        "/repair-types" => [$trainController, "getRepairTypes"],
    ],
    "POST" => [
        "/register" => [$userController, "registerUser"],
        "/login" => [$userController, "loginUser"],
        "/trains" => [$trainController, "addTrain"],
        "/repair-types" => [$trainController, "addRepairType"],
        "/train-repairs" => [$trainController, "addTrainRepair"],
    ],
    "PUT" => [
        "/trains" => [$trainController, "updateTrain"],
        "/trains/status" => [$trainController, "updateTrainStatus"],
    ],
    "DELETE" => [
        "/trains" => [$trainController, "deleteTrain"],
        "/train-repairs" => [$trainController, "deleteTrainRepair"],
    ]
];

// ✅ Gestion des routes dynamiques (ex: /trains/{id}/repairs)
$dynamicRoutes = [
    "GET" => [
        "#^/trains/(\d+)/repairs$#" => function ($matches) use ($trainController) {
            $trainController->getRepairsForTrain($matches[1]);
        }
    ]
];

// ✅ Vérifier si la route API demandée existe
if (isset($routes[$method][$request_uri])) {
    [$controller, $action] = $routes[$method][$request_uri];
    $controller->$action();
    exit;
}

// ✅ Vérifier les routes dynamiques
foreach ($dynamicRoutes[$method] ?? [] as $pattern => $callback) {
    if (preg_match($pattern, $request_uri, $matches)) {
        array_shift($matches); // Supprime l'élément 0 (match complet)
        $callback($matches);
        exit;
    }
}

// ❌ Gestion des erreurs
http_response_code(isset($routes[$method]) ? 404 : 405);
echo json_encode(["error" => isset($routes[$method]) ? "Route API non trouvée" : "Méthode non autorisée"]);
