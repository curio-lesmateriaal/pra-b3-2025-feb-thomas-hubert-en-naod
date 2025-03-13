if($action == "create"){
    
    $ = $_POST['attractie'];
    if(empty($attractie))
    $capaciteit = $_POST['capaciteit'];
    $melder = $_POST['melder'];
    $type = $_POST['type'];
    overige_info = $_POST['overige_info'];
    if(isset($_POST['prioriteit']))


    //1. Verbinding
    require_once '../../../config/conn.php';

    //2. Query
    $query = "INSERT INTO meldingen (attractie, capaciteit, melder, type, prioriteit, overige_info) VALUES(:attractie, :capaciteit, :melder, :type, :prioriteit, :overige_info)";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute([
        ":attractie" => $attractie,
        ":capaciteit" => $capaciteit,
        ":melder" => $melder,
        ":type" => $type,
        ":prioriteit" => $prioriteit,
        ":overige_info" => $overige_info
    ]);
    header("Location: ../../../resources/views/meldingen/index.php?msg=Melding opgeslagen");
}