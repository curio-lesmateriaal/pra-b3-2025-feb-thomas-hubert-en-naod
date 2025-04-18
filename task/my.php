<?php
// Laad de TaskController en controleer of gebruiker is ingelogd
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">
<head>
    <title>Mijn Taken</title>
    <?php require_once '../head.php'; ?>
    <!-- Laad de hoofdstijlen voor de applicatie -->
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <div class="container">
        <!-- Header met navigatie en titel -->
        <div class="header">
            <a href="../index.php" class="links" style="color:black">Terug naar home</a>
            <h1>Mijn Taken</h1>
        </div>
        
        <!-- Logo sectie -->
        <div class="foto">
            <img src="../image/logo-big-v3.png" alt="Pretpark Logo" class="logo"> 
        </div>
        
        <!-- Sectie voor persoonlijke taken -->
        <div class="my-tasks" style="margin-left: 250px;">
            <?php
            // Laad database connectie
            require_once '../backend/conn.php';

            // Haal alle taken op van de ingelogde gebruiker
            $query = "SELECT id, titel, beschrijving, afdeling, deadline, status FROM taken 
                      WHERE user = :user 
                      ORDER BY deadline ASC";
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
                            <th>Status</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($taken as $taak): ?>
                            <tr>
                                <!-- Toon taakgegevens -->
                                <td><?= htmlspecialchars($taak['titel']) ?></td>
                                <td><?= htmlspecialchars($taak['beschrijving']) ?></td>
                                <td><?= htmlspecialchars($taak['afdeling']) ?></td>
                                <td><?= date('d-m-Y', strtotime($taak['deadline'])) ?></td>
                                <td><?= htmlspecialchars($taak['status']) ?></td>
                                <td class="task-actions">
                                    <!-- Bewerk knop -->
                                    <a href="edit.php?id=<?= $taak['id'] ?>" class="button">Bewerken</a>
                                    
                                    <!-- Verwijder formulier -->
                                    <form action="../backend/taskController.php" method="POST" style="display: inline-block;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $taak['id'] ?>">
                                        <button type="submit" class="button" onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <!-- Toon bericht als er geen taken zijn -->
                <p>Je hebt nog geen taken.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
