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
        <div class="header">
            <a href="../index.php" class="links" style="color:black">Terug naar home</a>
            <h1>Mijn Taken</h1>
        </div>
        <div class="foto">
            <img src="../image/logo-big-v3.png" alt="Pretpark Logo" class="logo"> 
        </div>
        <div class="my-tasks" style="margin-left: 250px;">
            <?php
            require_once '../backend/conn.php';

            $query = "SELECT id, titel, beschrijving, afdeling, deadline, status FROM taken 
                      WHERE user = :user 
                      ORDER BY deadline ASC";
            $statement = $conn->prepare($query);
            $statement->execute([':user' => $_SESSION['user_id']]);
            $taken = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (count($taken) > 0): ?>
                <table class="done-table">
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
                                <td><?= htmlspecialchars($taak['titel']) ?></td>
                                <td><?= htmlspecialchars($taak['beschrijving']) ?></td>
                                <td><?= htmlspecialchars($taak['afdeling']) ?></td>
                                <td><?= date('d-m-Y', strtotime($taak['deadline'])) ?></td>
                                <td><?= htmlspecialchars($taak['status']) ?></td>
                                <td class="task-actions">
                                <a href="edit.php?id=<?= $taak['id'] ?>" class="button">Bewerken</a>
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
                <p>Je hebt nog geen taken.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
