<?php

if($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    die("invalid request");
}

require_once "./db.php";

$input_json = file_get_contents("php://input");

$input = json_decode($input_json, TRUE);

$query = "DELETE FROM cars WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

$stmt->bind_param("i", $input["id"]);

$success = $stmt->execute();

header("Content-Type: application/json; charset=utf-8");

if($success) {
    http_response_code(201);
    echo json_encode("Deleted");
}
else {
    http_response_code(500);
    echo json_encode($stmt->errno);
}