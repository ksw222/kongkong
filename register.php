<?php
$conn = new mysqli('localhost', 'root', '', 'kongkong_db', 3307);

if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo 'username_taken';
} else {
    $insert_sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}

$stmt->close();
$conn->close();
?>
