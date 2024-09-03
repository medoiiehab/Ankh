<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // الهروب من الأحرف الخاصة
    $problem_number = $conn->real_escape_string($_POST['problems']);
    $file_path = $conn->real_escape_string("uploads/" . basename($_FILES["file"]["name"]));
    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        die("حدث خطأ أثناء تحميل الملف.");
    }

    $team_name = $conn->real_escape_string($_POST['team_name']);
    $leader_name = $conn->real_escape_string($_POST['name']);
    $leader_email = $conn->real_escape_string($_POST['email']);
    $leader_phone = $conn->real_escape_string($_POST['phone']);
    $leader_university = $conn->real_escape_string($_POST['University']);
    $leader_graduation = $conn->real_escape_string($_POST['graduation']);
    $leader_speciality = $conn->real_escape_string($_POST['speciality']);

    $name1 = $conn->real_escape_string($_POST['name1']);
    $email1 = $conn->real_escape_string($_POST['email1']);
    $phone1 = $conn->real_escape_string($_POST['phone1']);
    $university1 = $conn->real_escape_string($_POST['University1']);
    $graduation1 = $conn->real_escape_string($_POST['graduation1']);
    $speciality1 = $conn->real_escape_string($_POST['speciality1']);

    $name2 = $conn->real_escape_string($_POST['name2']);
    $email2 = $conn->real_escape_string($_POST['email2']);
    $phone2 = $conn->real_escape_string($_POST['phone2']);
    $university2 = $conn->real_escape_string($_POST['University2']);
    $graduation2 = $conn->real_escape_string($_POST['graduation2']);
    $speciality2 = $conn->real_escape_string($_POST['speciality2']);

    $name3 = $conn->real_escape_string($_POST['name3']);
    $email3 = $conn->real_escape_string($_POST['email3']);
    $phone3 = $conn->real_escape_string($_POST['phone3']);
    $university3 = $conn->real_escape_string($_POST['University3']);
    $graduation3 = $conn->real_escape_string($_POST['graduation3']);
    $speciality3 = $conn->real_escape_string($_POST['speciality3']);

    $name4 = $conn->real_escape_string($_POST['name4']);
    $email4 = $conn->real_escape_string($_POST['email4']);
    $phone4 = $conn->real_escape_string($_POST['phone4']);
    $university4 = $conn->real_escape_string($_POST['University4']);
    $graduation4 = $conn->real_escape_string($_POST['graduation4']);
    $speciality4 = $conn->real_escape_string($_POST['speciality4']);

    // إعداد استعلام SQL
    $sql = "INSERT INTO registration (problem_number, file_path, team_name, leader_name, leader_email, leader_phone, leader_university, leader_graduation, leader_speciality,
                                       member1_name, member1_email, member1_phone, member1_university, member1_graduation, member1_speciality,
                                       member2_name, member2_email, member2_phone, member2_university, member2_graduation, member2_speciality,
                                       member3_name, member3_email, member3_phone, member3_university, member3_graduation, member3_speciality,
                                       member4_name, member4_email, member4_phone, member4_university, member4_graduation, member4_speciality)
            VALUES ('$problem_number', '$file_path', '$team_name', '$leader_name', '$leader_email', '$leader_phone', '$leader_university', '$leader_graduation', '$leader_speciality',
                    '$name1', '$email1', '$phone1', '$university1', '$graduation1', '$speciality1',
                    '$name2', '$email2', '$phone2', '$university2', '$graduation2', '$speciality2',
                    '$name3', '$email3', '$phone3', '$university3', '$graduation3', '$speciality3',
                    '$name4', '$email4', '$phone4', '$university4', '$graduation4', '$speciality4')";

    // تنفيذ استعلام SQL
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('تم تسجيل البيانات بنجاح!'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
