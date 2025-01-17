<?php
require_once __DIR__ . "/../models/db.php";

class UserController
{

    // Récupérer tous les utilisateurs
    public function getUsers()
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->query("SELECT id, username, email, created_at FROM users");
            echo json_encode(["users" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erreur lors de la récupération des utilisateurs"]);
        }
    }

    // Enregistrer un nouvel utilisateur
    public function registerUser()
    {
        $pdo = Database::getInstance();
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["username"], $data["email"], $data["password"])) {
            echo json_encode(["error" => "Données incomplètes"]);
            return;
        }

        $username = trim($data["username"]);
        $email = trim($data["email"]);
        $password = password_hash($data["password"], PASSWORD_DEFAULT);
        $is_superuser = isset($data["is_superuser"]) && $data["is_superuser"] === true ? 1 : 0;

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_superuser) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $password, $is_superuser]);

            echo json_encode(["message" => "Inscription réussie"]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erreur lors de l'inscription"]);
        }
    }


    // Connexion utilisateur
    public function loginUser()
    {
        $pdo = Database::getInstance();
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["email"], $data["password"])) {
            echo json_encode(["error" => "Données incomplètes"]);
            return;
        }

        $email = trim($data["email"]);
        $password = $data["password"];

        try {
            $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password"])) {
                echo json_encode(["message" => "Connexion réussie", "user" => ["id" => $user["id"], "username" => $user["username"]]]);
            } else {
                http_response_code(401);
                echo json_encode(["error" => "Email ou mot de passe incorrect"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erreur lors de la connexion"]);
        }
    }
}
