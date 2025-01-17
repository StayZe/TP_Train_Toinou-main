<?php
// ✅ Charger les contrôleurs et le routeur API si nécessaire
require_once __DIR__ . "/controllers/UserController.php";
require_once __DIR__ . "/controllers/TrainController.php";

// Récupérer la requête sans paramètres GET
$request_uri = strtok($_SERVER["REQUEST_URI"], '?');
$method = $_SERVER["REQUEST_METHOD"];

// ✅ 1️⃣ Servir la page web sur `/`
if ($method === "GET" && $request_uri === "/") {
    require_once __DIR__ . "/views/manage_trains.php";
    exit;
}

// ✅ 2️⃣ Déléguer les routes API à `routes/routes.php`
if (strpos($request_uri, "/api") === 0) {
    require_once __DIR__ . "/routes/routes.php";
    exit;
}

// ❌ 3️⃣ Si aucune route ne correspond, afficher une erreur 404
http_response_code(404);
echo "Page non trouvée.";
