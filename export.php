<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'db_connect.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="registrations.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Problem Number', 'Team Name', 'Leader Name', 'Leader Email', 'Leader Phone'));

$query = "SELECT * FROM registration";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
?>
