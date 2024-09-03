<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'menu.php';
include 'db_connect.php';

$query = "SELECT * FROM registration";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Teams Overview</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Team Name</th>
                    <th>Problem Number</th>
                    <th>Leader Name</th>
                    <th>Leader Email</th>
                    <th>Leader Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['team_name']; ?></td>
                            <td><?php echo $row['problem_number']; ?></td>
                            <td><?php echo $row['leader_name']; ?></td>
                            <td><?php echo $row['leader_email']; ?></td>
                            <td><?php echo $row['leader_phone']; ?></td>
                            <td><a href="view_team.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View Details</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No teams found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
