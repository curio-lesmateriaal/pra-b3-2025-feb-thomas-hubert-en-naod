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
            <a href="../index.php" class="links">Terug naar home</a>
        </div>
        <div class="header">
            <h1>Takenoverzicht</h1>
        </div>

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

        echo '<div class="task-columns">';
        foreach ($statussen as $status => $titel) {
            $stmt = $conn->prepare("SELECT * FROM taken WHERE status = ? ORDER BY deadline ASC");
            $stmt->execute([$status]);
            
            echo "<div class='task-column'><h2>$titel</h2><div class='task-list'>";
            while ($taak = $stmt->fetch(PDO::FETCH_ASSOC)) {
                toonTaakKaart($taak);
            }
            echo "</div></div>";
        }
        echo '</div>';
        ?>
    </div>
</body>

</html>