<?php
include 'db_connect.php';

header('Content-Type: application/json');
$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        getRegistrations();
        break;
    case 'POST':
        addRegistration();
        break;
    case 'PUT':
        updateRegistration();
        break;
    case 'DELETE':
        deleteRegistration();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getRegistrations() {
    global $conn;
    $query = "SELECT * FROM registration";
    $result = $conn->query($query);
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function addRegistration() {
    global $conn;
    $input = json_decode(file_get_contents('php://input'), true);
    // نفذ منطق الإضافة هنا
}

function updateRegistration() {
    global $conn;
    $input = json_decode(file_get_contents('php://input'), true);
    // نفذ منطق التعديل هنا
}

function deleteRegistration() {
    global $conn;
    $id = intval($_GET["id"]);
    $query = "DELETE FROM registration WHERE id = $id";
    if($conn->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
