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
                <button type="submit" class="links" style="background: none; cursor: pointer; color:black; font-size: 30px">uitloggen</button>
                
            </form>
        </div>

        <div class="hero">
            <img src="image/logo-big-v3.png">
            <div class="hero-content">
                <img src="image/logo-big-v3.png" alt="Pretpark Logo" class="logo">       
                <h1>Welkom bij het Pretpark Takensysteem</h1>
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
