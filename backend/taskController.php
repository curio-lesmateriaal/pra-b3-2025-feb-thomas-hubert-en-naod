<?php
require_once __DIR__ . '/conn.php';

$action = $_POST['action'] ?? '';

if($action == "create"){
    
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];

    //2. Query
    $query = "INSERT INTO taken (titel, beschrijving, afdeling, status, deadline)
              VALUES (:titel, :beschrijving, :afdeling, :status, :deadline)";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute([
        ":titel" => $titel,
        ":beschrijving" => $beschrijving,
        ":afdeling" => $afdeling,
        ":status" => $status,
        ":deadline" => $deadline
    ]);

    //5. Redirect naar het takenoverzicht
    header("Location: ../task/index.php");
    exit();
}

if($action == "edit"){
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
              WHERE id = :id";

    $statement = $conn->prepare($query);
    $statement->execute([
        ":titel" => $titel,
        ":beschrijving" => $beschrijving,
        ":afdeling" => $afdeling,
        ":status" => $status,
        ":deadline" => $deadline,
        ":id" => $id
    ]);

    header("Location: ../task/index.php");
    exit();
}

if ($action == "delete"){
    $id = $_POST['id'];
    
    $query = "DELETE FROM taken WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([":id" => $id]);

    header("Location: ../task/index.php");
    exit();
}

if ($action == "update_status") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $query = "UPDATE taken SET status = :status WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":status" => $status,
        ":id" => $id
    ]);

    header("Location: ../task/index.php");
    exit();
}
?>