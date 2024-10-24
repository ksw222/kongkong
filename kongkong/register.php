<?php
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
    var_dump($_POST); 
    $nickname = $_POST['nickname'];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);  // 암호 해시화
    $confirm_password = password_hash($_POST["confirm_password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $name = $_POST["name"];
    $age = (int)$_POST["age"];  // 정수형 변환
    $birthdate = $_POST["birthdate"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];

    // SQL 쿼리 준비
    $sql = "INSERT INTO users (nickname, username, password, confirm_password , email, name, age, birthdate, address, phone) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // 쿼리 바인딩: s(문자열), i(정수) 타입 맞추기
    $stmt->bind_param("ssssssiiss", $nickname, $username, $password, $confirm_password, $email, $name, $age, $birthdate, $address, $phone);

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
S