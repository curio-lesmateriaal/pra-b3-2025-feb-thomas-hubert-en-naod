<?php
require_once '../backend/conn.php';

// Haal alle taken op
try {
    $query = "SELECT * FROM tasks ORDER BY created_at DESC";
    $statement = $conn->prepare($query);
    $statement->execute();
    $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Er is een fout opgetreden bij het ophalen van de taken: " . $e->getMessage();
}
?>

<!doctype html>
<html lang="nl">

<head>
    <title>Pretpark Takensysteem - Overzicht</title>
    <?php require_once '../head.php'; ?>
</head>

<body>
    <div class="container">
        <div class="content-wrapper">
            <div class="nav-link">
                <a href="../index.php" class="links">Terug naar home</a>
                <a href="create.php" class="links">Nieuwe taak</a>
            </div>
            
            <h1>Taken Overzicht</h1>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert success">
                    Taak is succesvol toegevoegd!
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="tasks-grid">
                <?php if (empty($tasks)): ?>
                    <p class="no-tasks">Er zijn nog geen taken toegevoegd.</p>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <div class="task-card">
                            <h3><?php echo htmlspecialchars($task['titel']); ?></h3>
                            <p class="task-description"><?php echo htmlspecialchars($task['beschrijving']); ?></p>
                            <div class="task-meta">
                                <span class="task-afdeling">Afdeling: <?php echo htmlspecialchars($task['afdeling']); ?></span>
                                <span class="task-status">Status: 
                                    <?php 
                                        $status_text = [
                                            'todo' => 'Te doen',
                                            'doing' => 'In behandeling',
                                            'done' => 'Afgerond'
                                        ];
                                        echo htmlspecialchars($status_text[$task['status']] ?? $task['status']); 
                                    ?>
                                </span>
                                <span class="task-deadline">Deadline: <?php echo date('d-m-Y', strtotime($task['deadline'])); ?></span>
                                <span class="task-created">Aangemaakt op: <?php echo date('d-m-Y H:i', strtotime($task['created_at'])); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>