<?php
require_once 'backend/taskController.php';
requireLogin();
?>
<!doctype html>
<html lang="nl">

<head>
    <title>Home</title>
    <?php require_once 'head.php'; ?>
    
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <div class="container">
        <div class="nav-links">
            <span class="welcome">Welkom, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <form action="backend/taskController.php" method="post" style="display: inline;">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="links" style="border: none; background: none; cursor: pointer; color:black" >uitloggen</button>
            </form>
        </div>

        <div class="hero">
            <div class="hero-content">
                <h1>Welkom bij het Takenbeheer</h1>
                <div class="welcome-text">
                    <p>Kies hieronder wat u wilt doen:</p>
                </div>
                <div class="header-links" >
                    <a href="task/create.php" class="links"  style="color:black">Nieuwe taak</a>
                    <a href="task/index.php" class="links"  style="color:black">Takenoverzicht</a>
                    <a href="task/done.php" class="links"  style="color:black">Afgeronde taken</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
