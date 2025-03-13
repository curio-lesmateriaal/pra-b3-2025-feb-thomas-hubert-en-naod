<!doctype html>
<html lang="nl">

<head>
    <title></title>
    <?php require_once '../head.php'; ?>
    <a href="../index.php" class="links">Terug naar home</a>
</head>

<body>

<form action="../backend/tasksController.php" method="POST">
                <input type="hidden" name="action" value="create">
                
                <div class="form-group">
                    <label for="titel">Titel:</label>
                    <input type="text" id="titel" name="titel" required>
                </div>

                <div class="form-group">
                    <label for="beschrijving">Beschrijving:</label>
                    <textarea id="beschrijving" name="beschrijving" required></textarea>
                </div>

                <div class="form-group">
                    <label for="afdeling">Afdeling:</label>
                    <select id="afdeling" name="afdeling" required>
                        <option value="">Selecteer een afdeling</option>
                        <option value="personeel">Personeel</option>
                        <option value="horeca">Horeca</option>
                        <option value="techniek">Techniek</option>
                        <option value="inkoop">Inkoop</option>
                        <option value="klantenservice">Klantenservice</option>
                        <option value="groen">Groen</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="todo">Te doen</option>
                        <option value="doing">Doing</option>
                        <option value="done">Done</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="deadline">Deadline:</label>
                    <input type="date" id="deadline" name="deadline" required>
                </div>

                <div class="button-group">
                    <button type="submit" class="button">Taak Opslaan</button>
                    <a href="create.php" class="button">Annuleren</a>
                </div>
            </form>
    

</body>

</html>