<?php
// Laad de TaskController en controleer of gebruiker is ingelogd
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">

<head>
    <title>Takenoverzicht</title>
    <?php require_once '../head.php'; ?>
    <!-- Laad de hoofdstijlen voor de applicatie -->
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    
    <div class="container">
        <!-- Navigatie sectie -->
        <div class="nav-links">
            <a href="../index.php" class="links" style="color:black" >Terug naar home</a>
        </div>
        <div class="header">
            <h1>Takenoverzicht</h1>
        </div>

        <!-- Afdeling filter sectie -->
        <div class="afdeling-filter">
            <div class="afdeling">
            <?php
            // Array met alle beschikbare afdelingen
            $afdelingen = [
                'personeel' => 'Personeel',
                'horeca' => 'Horeca',
                'techniek' => 'Techniek',
                'inkoop' => 'Inkoop',
                'klantenservice' => 'Klantenservice',
                'groen' => 'Groen'
            ];
            
            // Maak voor elke afdeling een filter knop
            foreach ($afdelingen as $value => $label) {
                echo "<a href='afdeling.php?afdeling={$value}' class='button'>{$label}</a> ";
            }
            ?>
            </div>
        </div>

        <!-- Takenlijst in kolommen per status -->
        <div class="task-columns">
            <?php
            // Laad database connectie
            require_once '../backend/conn.php';
            
            // Array met alle mogelijke statussen
            $statussen = ['todo' => 'Te doen', 'doing' => 'In behandeling', 'done' => 'Afgerond'];
            
            // Functie om één taakkaart te tonen
            function toonTaakKaart($taak) { ?>
                <div class="task-card">
                    <!-- Toon taak informatie (met htmlspecialchars voor veiligheid) -->
                    <h3><?= htmlspecialchars($taak['titel']) ?></h3>
                    <p><?= htmlspecialchars($taak['beschrijving']) ?></p>
                    <p>Afdeling: <?= htmlspecialchars($taak['afdeling']) ?></p>
                    <p>Deadline: <?= date('d-m-Y', strtotime($taak['deadline'])) ?></p>
                    
                    <!-- Actieknoppen voor de taak -->
                    <div class="task-actions">
                        <!-- Bewerk knop -->
                        <a href="edit.php?id=<?= $taak['id'] ?>" class="button">Bewerken</a>
                        
                        <!-- Verwijder formulier -->
                        <form action="../backend/taskController.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $taak['id'] ?>">
                            <button type="submit" class="button" onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">Verwijderen</button>
                        </form>
                    </div>
                </div>
            <?php }

            // Loop door alle statussen om kolommen te maken
            foreach ($statussen as $status => $titel): ?>
                <div class="task-column">
                    <h2><?= $titel ?></h2>
                    <div class="task-list">
                        <?php
                        // Haal alle taken op voor deze status van de ingelogde gebruiker
                        $query = "SELECT * FROM taken WHERE status = :status AND user = :user ORDER BY deadline ASC";
                        $statement = $conn->prepare($query);
                        $statement->execute([
                            ':status' => $status,
                            ':user' => $_SESSION['user_id']
                        ]);
                        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);

                        // Als er geen taken zijn, toon bericht
                        if (empty($taken)) {
                            echo "<p>Geen taken in deze status.</p>";
                        } else {
                            // Anders, toon alle taken
                            foreach($taken as $taak) {
                                toonTaakKaart($taak);
                            }
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>