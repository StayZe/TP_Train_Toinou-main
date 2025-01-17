<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host = "tp-train-php-cssa.b.aivencloud.com";
        $port = "19266";
        $dbname = "defaultdb";
        $username = "avnadmin";
        $password = "AVNS_p6_VhU__o2yG8yxFXB4";
        $sslCertPath = __DIR__ . "/../ca.pem"; // Chemin du certificat SSL

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_SSL_CA => $sslCertPath
                ]
            );
        } catch (PDOException $e) {
            die(json_encode(["error" => "Erreur de connexion à la base de données"]));
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
