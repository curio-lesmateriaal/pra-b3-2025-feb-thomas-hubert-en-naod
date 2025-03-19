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

        <div class="task-columns">
            <?php
            require_once '../backend/conn.php';
            
            $statussen = [
                'todo' => 'Te doen',
                'doing' => 'In behandeling',
                'done' => 'Afgerond'
            ];

            function toonTaakKaart($taak) {
                ?>
                <div class="task-card">
                    <h3><?php echo htmlspecialchars($taak['titel']); ?></h3>
                    <p><?php echo htmlspecialchars($taak['beschrijving']); ?></p>
                    <p>Afdeling: <?php echo htmlspecialchars($taak['afdeling']); ?></p>
                    <p>Deadline: <?php echo date('d-m-Y', strtotime($taak['deadline'])); ?></p>
                    <div class="task-actions">
                        <form action="../backend/taskController.php" method="POST">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $taak['id']; ?>">
                            <button type="submit" class="button" onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">Verwijderen</button>
                        </form>
                    </div>
                </div>
                <?php
            }

            foreach ($statussen as $status => $titel): ?>
                <div class="task-column">
                    <h2><?php echo $titel; ?></h2>
                    <div class="task-list">
                        <?php
                        $query = "SELECT * FROM taken WHERE status = ? ORDER BY deadline ASC";
                        $statement = $conn->prepare($query);
                        $statement->execute([$status]);
                        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach($taken as $taak) {
                            toonTaakKaart($taak);
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>