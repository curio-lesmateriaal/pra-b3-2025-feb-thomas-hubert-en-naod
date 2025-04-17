<?php
// Start een nieuwe of hervat een bestaande sessie
session_start();
// Laad de database connectie
require_once __DIR__ . 'backend/conn.php';

//====================================
// AUTHENTICATIE FUNCTIES
//====================================

/**
 * Controleert of een gebruiker is ingelogd
 * @return bool true als gebruiker ingelogd is, anders false
 */
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Controleert of gebruiker is ingelogd, zo niet -> redirect naar login
 * Deze functie wordt gebruikt om pagina's te beveiligen
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}

//====================================
// ACTIE VERWERKING
//====================================

// Haal de gevraagde actie op uit het formulier
$action = $_POST['action'] ?? '';

//====================================
// LOGIN & LOGOUT AFHANDELING
//====================================

// LOGIN actie
if ($action === 'login') {
    // Haal inloggegevens op
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Controleer of alle velden zijn ingevuld
    if (empty($username) || empty($password)) {
        header('Location: ../login.php?error=empty');
        exit();
    }

    // Zoek gebruiker in database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Controleer of gebruiker bestaat
    if (!$user) {
        header('Location: ../login.php?error=invalid');
        exit();
    }

    // Controleer wachtwoord (case-sensitive vergelijking)
    if (strcmp($password, $user['password']) !== 0) {
        header('Location: ../login.php?error=invalid');
        exit();
    }

    // Sla gebruikersgegevens op in sessie
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['naam'] = $user['naam'];
    $_SESSION['logged_in'] = true;
    
    // Stuur door naar hoofdpagina
    header('Location: ../index.php');
    exit();
}

// LOGOUT actie
if ($action === 'logout') {
    // Verwijder alle sessiegegevens
    session_destroy();
    // Stuur terug naar login
    header('Location: /login.php');
    exit();
}

//====================================
// TAAK ACTIES
//====================================

// Controleer eerst of gebruiker is ingelogd voor alle taak acties
requireLogin();

// NIEUWE TAAK AANMAKEN
if($action === "create") {
    // Haal alle taakgegevens op uit het formulier
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];

    // Maak nieuwe taak aan in database
    $query = "INSERT INTO taken (titel, beschrijving, afdeling, status, deadline, user)
              VALUES (:titel, :beschrijving, :afdeling, :status, :deadline, :user)";

    // Voer query veilig uit met prepared statement
    $statement = $conn->prepare($query);
    $statement->execute([
        ":titel" => $titel,
        ":beschrijving" => $beschrijving,
        ":afdeling" => $afdeling,
        ":status" => $status,
        ":deadline" => $deadline,
        ":user" => $_SESSION['user_id']  // Koppel aan huidige gebruiker
    ]);

    // Stuur terug naar takenoverzicht
    header("Location: ../task/index.php");
    exit();
}

// TAAK BEWERKEN
if($action === "edit") {
    // Haal alle taakgegevens op uit het formulier
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $id = $_POST['id'];

    // Update de taak in database
    $query = "UPDATE taken 
              SET titel = :titel, 
                  beschrijving = :beschrijving, 
                  afdeling = :afdeling, 
                  status = :status, 
                  deadline = :deadline
              WHERE id = :id AND user = :user";  // Alleen eigen taken updaten

    // Voer query veilig uit met prepared statement
    $statement = $conn->prepare($query);
    $statement->execute([
        ":titel" => $titel,
        ":beschrijving" => $beschrijving,
        ":afdeling" => $afdeling,
        ":status" => $status,
        ":deadline" => $deadline,
        ":id" => $id,
        ":user" => $_SESSION['user_id']  // Controleer eigenaarschap
    ]);

    // Stuur terug naar takenoverzicht
    header("Location: ../task/index.php");
    exit();
}

// TAAK VERWIJDEREN
if ($action === "delete") {
    // Haal taak ID op
    $id = $_POST['id'];
    
    // Verwijder taak uit database (alleen als het van de gebruiker is)
    $query = "DELETE FROM taken WHERE id = :id AND user = :user";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":id" => $id,
        ":user" => $_SESSION['user_id']  // Controleer eigenaarschap
    ]);

    // Stuur terug naar takenoverzicht
    header("Location: ../task/index.php");
    exit();
}

// STATUS VAN TAAK BIJWERKEN
if ($action === "update_status") {
    // Haal taak ID en nieuwe status op
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    // Update alleen de status van de taak
    $query = "UPDATE taken SET status = :status WHERE id = :id AND user = :user";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":status" => $status,
        ":id" => $id,
        ":user" => $_SESSION['user_id']  // Controleer eigenaarschap
    ]);

    // Stuur terug naar takenoverzicht
    header("Location: ../task/index.php");
    exit();
}
?>