<?php
include("connection.php");
include("clients.php");

$connection = new Connection();
$connection->selectDatabase("pharmacie");

// Message de succès ou d'erreur
$errorMsg = "";
$successMsg = "";

// Si un client est à éditer
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $clientData = Clients::selectClientById("clients", $connection->conn, $id);
}

// Si un client est à supprimer
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    Clients::deleteClient("clients", $connection->conn, $id);
}

// Si un formulaire d'édition est soumis
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $telephone = $_POST['telephone'];
    $ville = $_POST['ville'];
    $email = $_POST['email'];

    // Mettre à jour le client
    $client = new Clients($firstname, $lastname, $ville, $telephone, $email, ""); // Le mot de passe n'est pas requis pour la mise à jour
    Clients::updateClient($client, "clients", $connection->conn, $id);
}

$clients = Clients::selectAllClients("clients", $connection->conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Liste des clients</h2>
        
        <!-- Message de succès ou d'erreur -->
        <?php if ($successMsg): ?>
        <div class="alert alert-success"><?= $successMsg; ?></div>
        <?php endif; ?>

        <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= $errorMsg; ?></div>
        <?php endif; ?>

        <!-- Liste des clients -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= $client['id']; ?></td>
                    <td><?= $client['firstname']; ?></td>
                    <td><?= $client['lastname']; ?></td>
                    <td><?= $client['telephone']; ?></td>
                    <td><?= $client['ville']; ?></td>
                    <td><?= $client['email']; ?></td>
                    <td>
                        <a href="read.php?edit=<?= $client['id']; ?>" class="btn btn-primary btn-sm">Éditer</a>
                        <a href="read.php?delete=<?= $client['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Formulaire d'édition -->
        <?php if (isset($clientData)): ?>
        <h3>Modifier le client</h3>
        <form action="read.php" method="POST">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <div class="mb-3">
                <label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $clientData['firstname']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $clientData['lastname']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="<?= $clientData['telephone']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ville" class="form-label">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" value="<?= $clientData['ville']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $clientData['email']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-success">Mettre à jour</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
