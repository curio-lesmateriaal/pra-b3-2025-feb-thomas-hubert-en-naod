<?php
// Laad de TaskController en controleer of gebruiker is ingelogd
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">

<head>
    <title>Taak Bewerken</title>
    <?php require_once '../head.php'; ?>
    <!-- Laad de hoofdstijlen voor de applicatie -->
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <div class="container">
        <!-- Navigatie link terug naar home -->
        <a href="../index.php" class="links">Terug naar home</a>
        <h1>Taak Bewerken</h1>

        <?php
        // Laad database connectie
        require_once '../backend/conn.php';
        
        // Controleer of er een taak ID is meegegeven
        $id = $_GET['id'] ?? null;
        if (!$id) {
            // Geen ID? Terug naar overzicht
            header('Location: index.php');
            exit();
        }

        // Haal de taak op uit de database (alleen van huidige gebruiker)
        $stmt = $conn->prepare("SELECT * FROM taken WHERE id = :id AND user = :user");
        $stmt->execute([
            ':id' => intval($id),
            ':user' => $_SESSION['user_id']
        ]);
        $taak = $stmt->fetch(PDO::FETCH_ASSOC);

        // Als taak niet bestaat of niet van deze gebruiker is
        if (!$taak) {
            header('Location: index.php');
            exit();
        }

        // Arrays met mogelijke opties voor dropdowns
        $afdelingen = [
            'personeel' => 'Personeel',
            'horeca' => 'Horeca',
            'techniek' => 'Techniek',
            'inkoop' => 'Inkoop',
            'klantenservice' => 'Klantenservice',
            'groen' => 'Groen'
        ];

        $statussen = [
            'todo' => 'Te doen',
            'doing' => 'In behandeling',
            'done' => 'Afgerond'
        ];
        ?>

        <!-- Formulier voor het bewerken van de taak -->
        <form action="../backend/taskController.php" method="POST">
            <!-- Hidden velden voor actie en taak ID -->
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $taak['id'] ?>">
            
            <!-- Titel invoerveld met huidige waarde -->
            <div class="form-group">
                <label for="titel">Titel:</label>
                <input type="text" id="titel" name="titel" required class="form-input" 
                    value="<?= htmlspecialchars($taak['titel']) ?>">
            </div>

            <!-- Beschrijving textarea met huidige waarde -->
            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <textarea id="beschrijving" name="beschrijving" required 
                    class="form-input"><?= htmlspecialchars($taak['beschrijving']) ?></textarea>
            </div>

            <!-- Afdeling dropdown met huidige waarde geselecteerd -->
            <div class="form-group">
                <label for="afdeling">Afdeling:</label>
                <select id="afdeling" name="afdeling" required class="form-input">
                    <option value="">Selecteer een afdeling</option>
                    <?php foreach($afdelingen as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $taak['afdeling'] === $value ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Status dropdown met huidige waarde geselecteerd -->
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required class="form-input">
                    <?php foreach($statussen as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $taak['status'] === $value ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Deadline datumkiezer met huidige waarde -->
            <div class="form-group">
                <label for="deadline">Deadline:</label>
                <input type="date" id="deadline" name="deadline" required class="form-input" 
                    value="<?= date('Y-m-d', strtotime($taak['deadline'])) ?>">
            </div>

            <!-- Knoppen voor opslaan of annuleren -->
            <div class="button-group">
                <button type="submit" class="button">Wijzigingen Opslaan</button>
                <a href="../index.php" class="button" style="color:black">Annuleren</a>
            </div>
        </form>
    </div>
</body>

</html> 