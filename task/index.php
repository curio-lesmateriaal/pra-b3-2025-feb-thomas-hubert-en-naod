<?php
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">

<head>
    <title>Takenoverzicht</title>
    <?php require_once '../head.php'; ?>
    
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    
    <div class="container">
        <div class="nav-links">
            <a href="../index.php" class="links" style="color:black" >Terug naar home</a>
        </div>
        <div class="header">
            <h1>Takenoverzicht</h1>
        </div>

        <div class="afdeling-filter">

            <?php
            $afdelingen = [
                'personeel' => 'Personeel',
                'horeca' => 'Horeca',
                'techniek' => 'Techniek',
                'inkoop' => 'Inkoop',
                'klantenservice' => 'Klantenservice',
                'groen' => 'Groen'
            ];

            foreach ($afdelingen as $value => $label) {
                echo "<a href='afdeling.php?afdeling={$value}' class='button'>{$label}</a> ";
            }
            ?>
        </div>

        <div class="task-columns">
            <?php
            require_once '../backend/conn.php';
            
            $statussen = ['todo' => 'Te doen', 'doing' => 'In behandeling', 'done' => 'Afgerond'];
            
            function toonTaakKaart($taak) { ?>
                <div class="task-card">
                    <h3><?= htmlspecialchars($taak['titel']) ?></h3>
                    <p><?= htmlspecialchars($taak['beschrijving']) ?></p>
                    <p>Afdeling: <?= htmlspecialchars($taak['afdeling']) ?></p>
                    <p>Deadline: <?= date('d-m-Y', strtotime($taak['deadline'])) ?></p>
                    <div class="task-actions">
                        <a href="edit.php?id=<?= $taak['id'] ?>" class="button">Bewerken</a>
                        <form action="../backend/taskController.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $taak['id'] ?>">
                            <button type="submit" class="button" onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">Verwijderen</button>
                        </form>
                    </div>
                </div>
            <?php }

            foreach ($statussen as $status => $titel): ?>
                <div class="task-column">
                    <h2><?= $titel ?></h2>
                    <div class="task-list">
                        <?php
                        $query = "SELECT * FROM taken WHERE status = :status AND user = :user ORDER BY deadline ASC";
                        $statement = $conn->prepare($query);
                        $statement->execute([
                            ':status' => $status,
                            ':user' => $_SESSION['user_id']
                        ]);
                        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($taken)) {
                            echo "<p>Geen taken in deze status.</p>";
                        } else {
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