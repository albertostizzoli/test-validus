<?php

// Connessione al database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "registration_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo la connessione al database
if($conn->connect_error){
    die(json_encode(['success' => false, 'message' => "Connessione fallita: " . $conn->connect_error]));
}

// Ricevo i dati dal form
$firstName = $_POST['firstName'] ?? null;
$lastName = $_POST['lastName'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$company = $_POST['company'] ?? null;
$state = $_POST['state'] ?? null;
$regDate = $_POST['regDate'] ?? null;

// Verifico se i campi del form sono vuoti
if(empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($company) || empty($state) || empty($regDate)){
    echo json_encode(['success' => false, 'message' => 'Tutti i campi devono essere compilati']);
    exit;
}

// Verifico se l'email è valida 
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo json_encode(['success' => false, 'message' => 'L/email non è valida']);
    exit;
}

// Inserisco i dati nel database
$sql = "INSERT INTO users (first_name, last_name, email, password, company, state, reg_date) VALUES ('$firstName', '$lastName', '$email', '$password', '$company', '$state', '$regDate')";

if($conn->query($sql) === TRUE){
    echo json_encode(['success' => true, 'message' => 'Dati salvati correttamente']);
}else{
    echo json_encode(['success' => false, 'message' => 'Errore ' . $sql . '<br>' . $conn->error]);
}

$conn->close();

?>