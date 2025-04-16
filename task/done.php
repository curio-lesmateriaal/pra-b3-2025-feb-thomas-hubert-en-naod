<?php
// Laad de TaskController en controleer of gebruiker is ingelogd
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">

<head>
    <title>Afgeronde Taken</title>
    <?php require_once '../head.php'; ?>
    <!-- Laad de hoofdstijlen voor de applicatie -->
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <div class="container">
        <!-- Header met navigatie en titel -->
        <div class="header">
            <a href="../index.php" class="links"  style="color:black">Terug naar home</a>
            <h1>Afgeronde Taken</h1>
        </div>
        
        <!-- Logo sectie -->
        <div class="foto">
            <img src="../image/logo-big-v3.png" alt="Pretpark Logo" class="logo"> 
        </div>
        
        <!-- Sectie voor afgeronde taken -->
        <div class="done-tasks">
            <?php
            // Laad database connectie
            require_once '../backend/conn.php';

            // Haal alle afgeronde taken op van de ingelogde gebruiker
            $query = "SELECT id, titel, beschrijving, afdeling, deadline FROM taken 
                     WHERE status = 'done' AND user = :user 
                     ORDER BY deadline DESC";
            $statement = $conn->prepare($query);
            $statement->execute([':user' => $_SESSION['user_id']]);
            $taken = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Als er taken zijn gevonden, toon ze in een tabel
            if (count($taken) > 0): ?>
                <table class="done-table">
                    <!-- Tabelkop met kolomnamen -->
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>Beschrijving</th>
                            <th>Afdeling</th>
                            <th>Deadline</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($taken as $taak): ?>
                            <tr>
                                <!-- Toon taakgegevens (beveiligd tegen XSS) -->
                                <td><?= htmlspecialchars($taak['titel']) ?></td>
                                <td><?= htmlspecialchars($taak['beschrijving']) ?></td>
                                <td><?= htmlspecialchars($taak['afdeling']) ?></td>
                                <td><?= date('d-m-Y', strtotime($taak['deadline'])) ?></td>
                                <td class="task-actions">
                                    <!-- Formulier om taak terug te zetten naar todo -->
                                    <form action="../backend/taskController.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="id" value="<?= $taak['id'] ?>">
                                        <input type="hidden" name="status" value="todo">
                                        <div class="terug">
                                            <button type="submit" class="button">Terugzetten</button>
                                        </div>
                                    </form>
                                    
                                    <!-- Formulier om taak te verwijderen -->
                                    <form action="../backend/taskController.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $taak['id'] ?>">
                                        <div class="delete">
                                            <button type="submit" class="button" onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">Verwijderen</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <!-- Toon bericht als er geen taken zijn -->
                <p>Er zijn geen afgeronde taken.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
