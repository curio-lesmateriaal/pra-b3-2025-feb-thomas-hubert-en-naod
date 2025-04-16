<?php
// Laad de TaskController en controleer of gebruiker is ingelogd
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">

<head>
    <title>Nieuwe Taak</title>
    <?php require_once '../head.php'; ?>
    <!-- Laad de hoofdstijlen voor de applicatie -->
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <div class="container">
        <!-- Navigatie link terug naar home -->
        <a href="../index.php" class="links">Terug naar home</a>
        <h1>Nieuwe Taak Aanmaken</h1>

        <!-- Formulier voor het aanmaken van een nieuwe taak -->
        <form action="../backend/taskController.php" method="POST">
            <!-- Hidden velden voor actie type en standaard status -->
            <input type="hidden" name="action" value="create">
            <input type="hidden" name="status" value="todo">
            
            <!-- Titel invoerveld -->
            <div class="form-group">
                <label for="titel">Titel:</label>
                <input type="text" id="titel" name="titel" required class="form-input">
            </div>

            <!-- Beschrijving textarea -->
            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <textarea id="beschrijving" name="beschrijving" required class="form-input"></textarea>
            </div>

            <!-- Afdeling dropdown met voorgedefinieerde opties -->
            <div class="form-group">
                <label for="afdeling">Afdeling:</label>
                <select id="afdeling" name="afdeling" required class="form-input">
                    <option value="">Selecteer een afdeling</option>
                    <option value="personeel">Personeel</option>
                    <option value="horeca">Horeca</option>
                    <option value="techniek">Techniek</option>
                    <option value="inkoop">Inkoop</option>
                    <option value="klantenservice">Klantenservice</option>
                    <option value="groen">Groen</option>
                </select>
            </div>

            <!-- Deadline datumkiezer -->
            <div class="form-group">
                <label for="deadline">Deadline:</label>
                <input type="date" id="deadline" name="deadline" required class="form-input">
            </div>

            <!-- Knoppen voor opslaan of annuleren -->
            <div class="button-group">
                <button type="submit" class="button">Taak Opslaan</button>
                <a href="../index.php" class="button" style="color:black">Annuleren</a>
            </div>
        </form>
    </div>
</body>

</html>