<?php session_start(); ?>
<!doctype html>
<html lang="nl">

<head>
    <title>Taak Bewerken</title>
    <?php require_once '../head.php'; ?>
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <div class="container">
        <a href="../index.php" class="links">Terug naar home</a>
        <h1>Taak Bewerken</h1>

        <?php
        require_once '../backend/conn.php';
        
        $id = $_GET['id'] ?? null;
        if (!$id || !($taak = $conn->query("SELECT * FROM taken WHERE id = " . intval($id))->fetch(PDO::FETCH_ASSOC))) {
            header('Location: index.php');
            exit();
        }

        $afdelingen = [
            'personeel' => 'Personeel',
            'horeca' => 'Horeca',
            'techniek' => 'Techniek',
            'inkoop' => 'Inkoop',
            'klantenservice' => 'Klantenservice',
            'groen' => 'Groen'
        ];

        $statussen = [
            'todo' => 'Te doen',
            'doing' => 'In behandeling',
            'done' => 'Afgerond'
        ];
        ?>

        <form action="../backend/taskController.php" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $taak['id'] ?>">
            
            <div class="form-group">
                <label for="titel">Titel:</label>
                <input type="text" id="titel" name="titel" required class="form-input" 
                    value="<?= htmlspecialchars($taak['titel']) ?>">
            </div>

            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <textarea id="beschrijving" name="beschrijving" required 
                    class="form-input"><?= htmlspecialchars($taak['beschrijving']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="afdeling">Afdeling:</label>
                <select id="afdeling" name="afdeling" required class="form-input">
                    <option value="">Selecteer een afdeling</option>
                    <?php foreach($afdelingen as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $taak['afdeling'] === $value ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required class="form-input">
                    <?php foreach($statussen as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $taak['status'] === $value ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="deadline">Deadline:</label>
                <input type="date" id="deadline" name="deadline" required class="form-input" 
                    value="<?= date('Y-m-d', strtotime($taak['deadline'])) ?>">
            </div>

            <div class="button-group">
                <button type="submit" class="button">Wijzigingen Opslaan</button>
                <a href="index.php" class="button">Annuleren</a>
            </div>
        </form>
    </div>
</body>

</html> 