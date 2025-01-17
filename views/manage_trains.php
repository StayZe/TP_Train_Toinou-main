<?php
require_once __DIR__ . "/../controllers/TrainController.php";

// ✅ Créer une instance du contrôleur
$trainController = new TrainController();

// ✅ Récupérer les données (maintenant sous forme de string JSON)
$trains = json_decode($trainController->getTrains(), true);
$repairTypes = json_decode($trainController->getRepairTypes(), true);

// ✅ Vérifier si les données existent avant de les afficher
if (!$trains) {
    echo "<p>⚠️ Erreur : Impossible de récupérer les trains.</p>";
}
if (!$repairTypes) {
    echo "<p>⚠️ Erreur : Impossible de récupérer les types de réparations.</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Trains 🚆</title>
</head>

<body>

    <h2>🚆 Liste des Trains</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trains as $train): ?>
                <tr>
                    <td><?= htmlspecialchars($train['id']) ?></td>
                    <td><?= htmlspecialchars($train['name']) ?></td>
                    <td><?= htmlspecialchars($train['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>🛠️ Types de Réparations</h2>
    <ul>
        <?php foreach ($repairTypes as $repair): ?>
            <li><?= htmlspecialchars($repair['name']) ?></li>
        <?php endforeach; ?>
    </ul>

</body>

</html>