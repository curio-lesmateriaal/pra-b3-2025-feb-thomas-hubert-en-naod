<?php
session_start();
require_once __DIR__ . '/conn.php';

// Auth functies
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}

// Haal actie op
$action = $_POST['action'] ?? '';

// Login, register en logout acties
if ($action === 'login') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header('Location: ../login.php?error=empty');
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header('Location: ../login.php?error=invalid');
        exit();
    }

    // Vergelijk wachtwoorden (case-sensitive)
    if (strcmp($password, $user['password']) !== 0) {
        header('Location: ../login.php?error=invalid');
        exit();
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['naam'] = $user['naam'];
    $_SESSION['logged_in'] = true;
    header('Location: ../index.php');
    exit();
}

if ($action === 'register') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $naam = $_POST['naam'] ?? '';

    if (empty($username) || empty($password) || empty($password_confirm) || empty($naam)) {
        header('Location: ../register.php?error=empty');
        exit();
    }

    if (strcmp($password, $password_confirm) !== 0) {
        header('Location: ../register.php?error=password');
        exit();
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        header('Location: ../register.php?error=exists');
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, naam) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $password, $naam])) {
        $_SESSION['user_id'] = $conn->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['naam'] = $naam;
        $_SESSION['logged_in'] = true;
        header('Location: ../index.php');
    } else {
        header('Location: ../register.php?error=unknown');
    }
    exit();
}

if ($action === 'logout') {
    session_destroy();
    header('Location: /login.php');
    exit();
}

// Controleer login voor taak acties
requireLogin();

// Taak acties
if($action === "create") {
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];

    $query = "INSERT INTO taken (titel, beschrijving, afdeling, status, deadline, user)
              VALUES (:titel, :beschrijving, :afdeling, :status, :deadline, :user)";

    $statement = $conn->prepare($query);
    $statement->execute([
        ":titel" => $titel,
        ":beschrijving" => $beschrijving,
        ":afdeling" => $afdeling,
        ":status" => $status,
        ":deadline" => $deadline,
        ":user" => $_SESSION['user_id']
    ]);

    header("Location: ../task/index.php");
    exit();
}

if($action === "edit") {
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $id = $_POST['id'];

    $query = "UPDATE taken 
              SET titel = :titel, 
                  beschrijving = :beschrijving, 
                  afdeling = :afdeling, 
                  status = :status, 
                  deadline = :deadline
              WHERE id = :id AND user = :user";

    $statement = $conn->prepare($query);
    $statement->execute([
        ":titel" => $titel,
        ":beschrijving" => $beschrijving,
        ":afdeling" => $afdeling,
        ":status" => $status,
        ":deadline" => $deadline,
        ":id" => $id,
        ":user" => $_SESSION['user_id']
    ]);

    header("Location: ../task/index.php");
    exit();
}

if ($action === "delete") {
    $id = $_POST['id'];
    
    $query = "DELETE FROM taken WHERE id = :id AND user = :user";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":id" => $id,
        ":user" => $_SESSION['user_id']
    ]);

    header("Location: ../task/index.php");
    exit();
}

if ($action === "update_status") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $query = "UPDATE taken SET status = :status WHERE id = :id AND user = :user";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":status" => $status,
        ":id" => $id,
        ":user" => $_SESSION['user_id']
    ]);

    header("Location: ../task/index.php");
    exit();
}
?>