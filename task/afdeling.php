<?php
// Laad de TaskController en controleer of gebruiker is ingelogd
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">
<head>
    <title>Taken per Afdeling</title>
    <?php require_once '../head.php'; ?>
    <!-- Laad de hoofdstijlen voor de applicatie -->
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <?php
    // Laad database connectie
    require_once '../backend/conn.php';
    
    // Definieer toegestane afdelingen met hun weergavenamen
    $toegestaneAfdelingen = [
        'personeel' => 'Personeel',
        'horeca' => 'Horeca',
        'techniek' => 'Techniek',
        'inkoop' => 'Inkoop',
        'klantenservice' => 'Klantenservice',
        'groen' => 'Groen'
    ];

    // Haal afdeling uit URL en valideer
    $afdeling = $_GET['afdeling'] ?? '';
    if (empty($afdeling) || !isset($toegestaneAfdelingen[$afdeling])) {
        // Ongeldige afdeling? Terug naar overzicht
        header('Location: index.php');
        exit();
    }

    // Array met alle mogelijke statussen
    $statussen = ['todo' => 'Te doen', 'doing' => 'In behandeling', 'done' => 'Afgerond'];
    ?>

    <div class="container">
        <!-- Navigatie links -->
        <div class="nav-links">
            <a href="../index.php" class="links" style="color:black">Terug naar home</a>
            <a href="index.php" class="links" style="color:black">Terug naar alle taken</a>
        </div>

        <!-- Paginatitel met afdelingsnaam -->
        <div class="header">
            <h1>Taken van afdeling: <?= htmlspecialchars($toegestaneAfdelingen[$afdeling]) ?></h1>
        </div>

        <!-- Takenlijst in kolommen per status -->
        <div class="task-columns">
            <?php foreach ($statussen as $status => $statusTitel): 
                // Haal taken op voor deze status en afdeling
                $stmt = $conn->prepare("SELECT * FROM taken WHERE status = ? AND afdeling = ? ORDER BY deadline ASC");
                $stmt->execute([$status, $afdeling]);
            ?>
                <div class="task-column">
                    <h2><?= $statusTitel ?></h2>
                    <div class="task-list">
                        <?php if ($taken = $stmt->fetchAll(PDO::FETCH_ASSOC)): 
                            // Loop door alle taken in deze status
                            foreach($taken as $taak): ?>
                                <!-- Taakkaart met details -->
                                <div class="task-card">
                                    <h3><?= htmlspecialchars($taak['titel']) ?></h3>
                                    <p><?= htmlspecialchars($taak['beschrijving']) ?></p>
                                    <p>Deadline: <?= date('d-m-Y', strtotime($taak['deadline'])) ?></p>
                                    <!-- Actieknoppen -->
                                    <div class="task-actions">
                                        <a href="edit.php?id=<?= $taak['id'] ?>" class="button">Bewerken</a>
                                        <form action="../backend/taskController.php" method="POST" style="display: inline-block;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $taak['id'] ?>">
                                            <button type="submit" class="button" onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">Verwijderen</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <!-- Toon bericht als er geen taken zijn -->
                            <p>Geen taken in deze status.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 
