<?php
session_start();
$host = "localhost";
$username = "root";
$password = ""; // XAMPP 기본 비밀번호
$dbname = "kongkong_db"; // 데이터베이스 이름
$port = 3307;

// 데이터베이스 연결
$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // 사용자 이름으로 데이터베이스에서 조회
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($input_password, $user["password"])) {
            $_SESSION["username"] = $input_username;
            echo "
                <script>
                    localStorage.setItem('loggedin', 'true');
                    localStorage.setItem('username', '$input_username');
                    alert('로그인에 성공했습니다!');
                    window.location.href = 'kongkong1.html';
                </script>";
            exit();
        } else {
            echo "<script>alert('비밀번호가 틀렸습니다.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('존재하지 않는 사용자입니다.'); window.history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>
