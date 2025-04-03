<?php session_start(); ?>
<!doctype html>
<html lang="nl">

<head>
    <title>Pretpark Takensysteem</title>
    <?php require_once 'head.php'; ?>
    
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <div class="container">
        <nav class="nav-links">
            <a href="task/create.php" class="links">nieuwe taken</a>
            <a href="task/index.php" class="links">Taken overzicht</a>
            <a href="task/done.php" class="links">Afgeronde Taken</a>
        </nav>

        <div class="hero">
            <div class="hero-content">
                <img src="image/logo-big-v3.png" alt="Pretpark Logo" class="logo">       
                <h1>Welkom bij het Pretpark Takensysteem</h1>
                <p class="welcome-text">
                    Beheer hier alle taken voor het pretpark. 
                    Maak nieuwe taken aan, werk bestaande taken bij en houd overzicht over alle afdelingen.
                </p>   
            </div>
        </div>
    </div>
</body>

</html>
