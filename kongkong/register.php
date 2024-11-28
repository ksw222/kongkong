<?php
// 오류 표시 (디버깅용)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$dbname = "kongkong_db";  // 데이터베이스 이름
$username = "root";
$password = "";
$port = 3307;  // 데이터베이스 포트

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST 요청으로 데이터 수신
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 입력값 변수 설정
    $nickname = $_POST['nickname'];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"]; // 확인용 비밀번호
    $email = $_POST["email"];
    $name = $_POST["name"];
    $age = (int)$_POST["age"];  // 정수형 변환
    $birthdate = $_POST["birthdate"];
    $address = $_POST["address"];
    $detail_address = $_POST["detailAddress"]; // HTML name 속성과 일치해야 함
    $phone = $_POST["phone"];

    // 비밀번호 확인
    if ($password !== $confirm_password) {
        echo "<script>alert('비밀번호가 일치하지 않습니다. 다시 입력해 주세요.'); window.history.back();</script>";
        exit();
    }

    // 비밀번호 해시화
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // SQL 쿼리 준비 (confirm_password 필드 제거)
    $sql = "INSERT INTO users (nickname, username, password, email, name, age, birthdate, address, detail_address, phone) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // 바인딩 (데이터 타입 맞추기)
    $stmt->bind_param("sssssisiss", $nickname, $username, $hashed_password, $email, $name, $age, $birthdate, $address, $detail_address, $phone);

    // 쿼리 실행 및 오류 처리
    if ($stmt->execute()) {
        echo "<script>alert('회원가입이 완료되었습니다!'); window.location.href='login.html';</script>";
    } else {
        echo "회원가입 실패: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
