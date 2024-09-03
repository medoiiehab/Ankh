<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'menu.php';
include 'db_connect.php';

$id = intval($_GET['id']);
$query = "SELECT * FROM registration WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $team = $result->fetch_assoc();
} else {
    echo "No team found with the given ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Team Details</h1>

        <h2>Team Name: <?php echo $team['team_name']; ?></h2>
        <p><strong>Problem Number:</strong> <?php echo $team['problem_number']; ?></p>
        <p><strong>Leader Name:</strong> <?php echo $team['leader_name']; ?></p>
        <p><strong>Leader Email:</strong> <?php echo $team['leader_email']; ?></p>
        <p><strong>Leader Phone:</strong> <?php echo $team['leader_phone']; ?></p>
        <p><strong>Leader University:</strong> <?php echo $team['leader_university']; ?></p>
        <p><strong>Leader Graduation Date:</strong> <?php echo $team['leader_graduation']; ?></p>
        <p><strong>Leader Speciality:</strong> <?php echo $team['leader_speciality']; ?></p>

        <!-- أعضاء الفريق -->
        <h3>Team Members</h3>
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <?php if (!empty($team["member{$i}_name"])): ?>
                <h4>Member <?php echo $i; ?></h4>
                <p><strong>Name:</strong> <?php echo $team["member{$i}_name"]; ?></p>
                <p><strong>Email:</strong> <?php echo $team["member{$i}_email"]; ?></p>
                <p><strong>Phone:</strong> <?php echo $team["member{$i}_phone"]; ?></p>
                <p><strong>University:</strong> <?php echo $team["member{$i}_university"]; ?></p>
                <p><strong>Graduation Date:</strong> <?php echo $team["member{$i}_graduation"]; ?></p>
                <p><strong>Speciality:</strong> <?php echo $team["member{$i}_speciality"]; ?></p>
            <?php endif; ?>
        <?php endfor; ?>

        <!-- عرض الملف -->
        <h3>Uploaded File</h3>
        <p><a href="<?php echo $team['file_path']; ?>" download>Download File</a></p>
    </div>
</body>
</html>
