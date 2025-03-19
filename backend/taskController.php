<?
if($action == "create"){
    
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $user = $_POST['user'];
    $created_at = $_POST['created_at'];


    //1. Verbinding
    require_once 'backend/conn.php';

    //2. Query
    $query = "INSERT INTO taken (titel, beschrijving, afdeling, status, deadline, user, created_at)
    VALUES(:titel, :beschrijving, :afdeling, :status, :deadline, :user, :created_at)";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute([
        ":titel" => $titel,
        ":beschrijving" => $beschrijving,
        ":afdeling" => $afdeling,
        ":status" => $status,
        ":deadline" => $deadline,
        ":user" => $user,
        ":created_at" => $created_at
    ]);
    header("Location: ../index.php?msg=taak aangemaakt");
}
if($action == "edit"){
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $user = $_POST['user'];
    $created_at = $_POST['created_at'];
    $id = $_POST['id'];

    // 1. Verbinding
    require_once '../../../backend/conn.php';

    // 2. Query
    $query = "UPDATE taken (titel, beschrijving, afdeling, status, deadline, user, created_at)
                VALUES(:titel, :beschrijving, :afdeling, :status, :deadline, :user, :created_at)";
    // 3. Prepare
    $statement = $conn->prepare($query);

    // 4. Execute
    $statement->execute([
        ":titel" => $titel,
        ":beschrijving" => $beschrijving,
        ":afdeling" => $afdeling,
        ":status" => $status,
        ":deadline" => $deadline,
        ":user" => $user,
        ":created_at" => $created_at,
        ":id" => $id
    ]);

    header("Location: ../index.php?msg=taak bewerkt");
}
if ($action == "delete"){
    $id = $_POST['id'];
    // 1. Verbinding
    require_once '../../../backend/conn.php';

    // 2. Query
    $query = "DELETE FROM taken WHERE id = :id";

    // 3. Prepare
    $statement = $conn->prepare($query);

    // 4. Execute
    $statement->execute([
        ":id" => $id
    ]);

    header("Location: ../../../resources/views/meldingen/index.php?msg=taak verwijderd");
}
?>