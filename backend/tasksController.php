<?php
require_once 'conn.php';

// Controleer welke actie er wordt uitgevoerd
$action = $_POST['action'] ?? '';

switch($action) {
    case 'create':
        createTask($conn);
        break;
    default:
        header('Location: ../index.php');
        exit;
}

function createTask($conn) {
    try {
        // Haal de form data op
        $titel = $_POST['titel'] ?? '';
        $beschrijving = $_POST['beschrijving'] ?? '';
        $afdeling = $_POST['afdeling'] ?? '';
        $status = $_POST['status'] ?? 'todo';
        $deadline = $_POST['deadline'] ?? '';

        // Valideer de verplichte velden
        if (empty($titel) || empty($beschrijving) || empty($afdeling)) {
            throw new Exception("Alle velden zijn verplicht!");
        }

        // Bereid de SQL query voor
        $sql = "INSERT INTO tasks (titel, beschrijving, afdeling, status, deadline, created_at) 
                VALUES (:titel, :beschrijving, :afdeling, :status, :deadline, NOW())";
        
        $stmt = $conn->prepare($sql);
        
        // Voer de query uit met de waarden
        $stmt->execute([
            ':titel' => $titel,
            ':beschrijving' => $beschrijving,
            ':afdeling' => $afdeling,
            ':status' => $status,
            ':deadline' => $deadline
        ]);

        // Redirect naar het overzicht
        header('Location: ../task/index.php?success=1');
        exit;

    } catch (Exception $e) {
        // Bij een fout, redirect met een foutmelding
        header('Location: ../task/create.php?error=' . urlencode($e->getMessage()));
        exit;
    }
} 