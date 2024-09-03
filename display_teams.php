<?php
include 'db_connect.php';

$filter_problem = isset($_GET['problem_number']) ? $_GET['problem_number'] : '';

$sql = "SELECT * FROM registration";
if ($filter_problem) {
    $sql .= " WHERE problem_number = '$filter_problem'";
}

$result = $conn->query($sql);

echo "<form method='GET' action='display_teams.php'>";
echo "<label for='problem_number'>تصفية حسب رقم المشكلة:</label>";
echo "<input type='text' name='problem_number' id='problem_number' value='$filter_problem'>";
echo "<button type='submit'>تصفية</button>";
echo "</form>";

if ($result->num_rows > 0) {
    echo "<h2>الفرق المسجلة:</h2>";
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>رقم المشكلة: " . $row["problem_number"]. "</h3>";
        echo "<p>اسم القائد: " . $row["leader_name"]. "</p>";
        echo "<p>البريد الإلكتروني: " . $row["leader_email"]. "</p>";
        echo "<p>الجامعة: " . $row["leader_university"]. "</p>";
        echo "<p>فترة التحدي: " . $row["challenge_period"]. "</p>"; // عرض فترة التحدي
        echo "<hr>";
        echo "</div>";
    }
} else {
    echo "لا توجد فرق مسجلة.";
}

$conn->close();
?>
