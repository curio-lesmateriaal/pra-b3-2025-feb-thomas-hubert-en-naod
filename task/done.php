<?php
require_once '../backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">

<head>
    <title>Afgeronde Taken</title>
    <?php require_once '../head.php'; ?>
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="../index.php" class="links"  style="color:black">Terug naar home</a>
            <h1>Afgeronde Taken</h1>
        </div>

        <div class="done-tasks">
            <?php
            require_once '../backend/conn.php';

            $query = "SELECT id, titel, beschrijving, afdeling, deadline FROM taken 
                     WHERE status = 'done' AND user = :user 
                     ORDER BY deadline DESC";
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
                                <td class="task-actions">
                                    <form action="../backend/taskController.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="id" value="<?= $taak['id'] ?>">
                                        <input type="hidden" name="status" value="todo">
                                        <button type="submit" class="button">Terugzetten</button>
                                    </form>
                                    <form action="../backend/taskController.php" method="POST" style="display: inline;">
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
                <p>Er zijn geen afgeronde taken.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
