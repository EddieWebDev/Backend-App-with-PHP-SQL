<?php

if($_SERVER["REQUEST_METHOD"] !== "PUT") {
    die("invalid request");
}

require_once "./db.php";

$input_json = file_get_contents("php://input");

$input = json_decode($input_json, TRUE);

$query = "UPDATE cars SET model = ?, make = ? WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

$stmt->bind_param("ssi",$input["model"], $input["make"], $input["id"]);

$success = $stmt->execute();

if($success) {
    http_response_code(201);
    echo json_encode("Updated");
}
else {
    http_response_code(500);
    echo json_encode($stmt->errno);
}