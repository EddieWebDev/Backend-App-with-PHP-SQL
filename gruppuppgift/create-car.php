<?php

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("invalid request");
}

require_once "./db.php";

$input_json = file_get_contents("php://input");

$input = json_decode($input_json, TRUE);

$query = "INSERT INTO cars (model, make) VALUES (?, ?)";

$stmt = mysqli_prepare($conn, $query);

// ss står för string string och står för ?, ? på rad 13
$stmt->bind_param("ss", $input["model"], $input["make"]);

$success = $stmt->execute();

header("Content-Type: application/json; charset=utf-8");

if($success) {
    http_response_code(201);
    echo json_encode("Created");
}
else {
    http_response_code(500);
    echo json_encode($stmt->errno);
}
