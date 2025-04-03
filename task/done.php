<?php session_start(); ?>
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
        <a href="index.php" class="links">Naar Takenoverzicht</a>
            <h1>Afgeronde Taken</h1>
        </div>

        <div class="done-tasks">
            <?php
   
            require_once '../backend/conn.php';

            
            $query = "SELECT id, titel, afdeling FROM taken WHERE status = 'done' ORDER BY deadline DESC";

          
            $statement = $conn->prepare($query);

         
            $statement->execute();

      
            $taken = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (count($taken) > 0): ?>
                <table class="done-table">
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>Afdeling</th>
                            <th>Actie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($taken as $taak): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($taak['titel']); ?></td>
                                <td><?php echo htmlspecialchars($taak['afdeling']); ?></td>
                                <td class="task-actions">
                                    <form action="../backend/taskController.php" method="POST">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $taak['id']; ?>">
                                        <button type="submit" class="button" onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
