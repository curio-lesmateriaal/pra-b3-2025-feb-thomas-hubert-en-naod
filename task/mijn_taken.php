<?php
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">
<head>
    <title>Mijn Taken</title>
    <?php require_once '../head.php'; ?>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="../index.php" class="links" style="color:black">Terug naar home</a>
            <a href="index.php" class="links" style="color:black">Terug naar alle taken</a>
        </div>

        <div class="header">
            <h1>Mijn Taken</h1>
        </div>

        <div class="task-columns">
            <?php 
            require_once '../backend/conn.php';
            $statussen = ['todo' => 'Te doen', 'doing' => 'In behandeling', 'done' => 'Afgerond'];
            
            foreach ($statussen as $status => $statusTitel): 
                $stmt = $conn->prepare("SELECT * FROM taken WHERE status = ? AND user = ? ORDER BY deadline ASC");
                $stmt->execute([$status, $_SESSION['user_id']]);
            ?>
                <div class="task-column">
                    <h2><?= $statusTitel ?></h2>
                    <div class="task-list">
                        <?php if ($taken = $stmt->fetchAll(PDO::FETCH_ASSOC)): 
                            foreach($taken as $taak): ?>
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
                            <?php endforeach;
                        else: ?>
                            <p>Geen taken in deze status.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 