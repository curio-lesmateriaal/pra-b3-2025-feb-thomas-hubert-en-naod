<!doctype html>
<html lang="nl">
<head>
    <title>Account Aanmaken</title>
    <?php require_once 'head.php'; ?>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h1>Account Aanmaken</h1>
            
            <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error === 'exists') {
                    echo '<p class="error">Deze gebruikersnaam bestaat al</p>';
                } elseif ($error === 'password') {
                    echo '<p class="error">Wachtwoorden komen niet overeen</p>';
                } elseif ($error === 'empty') {
                    echo '<p class="error">Vul alle velden in</p>';
                }
            }
            ?>

            <form action="backend/taskController.php" method="POST">
                <input type="hidden" name="action" value="register">
                
                <div class="form-group">
                    <label for="naam">Naam:</label>
                    <input type="text" id="naam" name="naam" required class="form-input" placeholder="naam">
                </div>

                <div class="form-group">
                    <label for="username">Gebruikersnaam:</label>
                    <input type="text" id="username" name="username" required class="form-input" placeholder="gebruikersnaam">
                </div>

                <div class="form-group">
                    <label for="password">Wachtwoord:</label>
                    <input type="password" id="password" name="password" required class="form-input" placeholder="wachtwoord">
                </div>

                <div class="form-group">
                    <label for="password_confirm">Wachtwoord bevestigen:</label>
                    <input type="password" id="password_confirm" name="password_confirm" required class="form-input" placeholder="Bevestig wachtwoord">
                </div>

                <div class="button-group">
                    <button type="submit" class="button">klaar</button>

                    <a href="login.php" class="button" style="color:black"   text-decoration="none" >Terug naar Inloggen</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 