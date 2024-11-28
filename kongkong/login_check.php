<?php
session_start();
$host = "localhost";
$username = "root";
$password = ""; // XAMPP 기본 비밀번호
$dbname = "kongkong_db";
$port = 3307;

// 데이터베이스 연결
$conn = new mysqli($host, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// POST로 전달된 아이디와 비밀번호 받기
$input_username = $_POST['username'];
$input_password = $_POST['password'];

// 아이디가 숫자로만 이루어져 있는지 확인하는 정규 표현식
if (preg_match('/^\d+$/', $input_username)) {
    // 아이디가 숫자로만 이루어진 경우 로그인 실패 처리
    header("Location: login.html?login=fail");
    exit;
}

// 사용자 이름으로 데이터베이스에서 조회
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL prepare error: " . $conn->error);
}

$stmt->bind_param("s", $input_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($input_password, $user["password"])) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $input_username;
        header("Location: kongkong1.php");
        exit();
    } else {
        header("Location: login.html?login=fail"); // 비밀번호 오류 시 리디렉션
    }
} else {
    header("Location: login.html?login=fail"); // 존재하지 않는 사용자 처리
}

$stmt->close();
$conn->close();
?>
