<!doctype html>
<html lang="nl">
<head>
    <title>Inloggen</title>
    <?php require_once 'head.php'; ?>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body >
    <div class="container">
        <div class="login-form">
            <h1>Inloggen</h1>
            
            <?php
            // Toon eventuele foutmeldingen
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error === 'empty') {
                    echo '<p class="error">Vul alle velden in</p>';
                } else if ($error === 'invalid') {
                    echo '<p class="error">Ongeldige gebruikersnaam of wachtwoord</p>';
                }
            }
            ?>

            <form action="backend/taskController.php" method="POST">
                <input type="hidden" name="action" value="login">
                
                <div class="form-group">
                    <label for="username">Gebruikersnaam:</label>
                    <input type="text" id="username" name="username" required class="form-input">
                </div>

                <div class="form-group">
                    <label for="password">Wachtwoord:</label>
                    <input type="password" id="password" name="password" required class="form-input">
                </div>

                <div class="button-group">
                    <button type="submit" class="button">Inloggen</button>
                </div>
            </form>
      
        </div>
    </div>
</body>
</html> 