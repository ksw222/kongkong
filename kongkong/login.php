<?php
// 오류 표시 설정
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$host = "localhost";
$username = "root";
$password = ""; // XAMPP 기본 비밀번호
$dbname = "kongkong_db"; // 데이터베이스 이름
$port = 3307;

// 데이터베이스 연결
$conn = new mysqli($host, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // 사용자 이름으로 데이터베이스에서 조회
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    // prepare()가 실패했는지 확인
    if (!$stmt) {
        die("SQL prepare error: " . $conn->error);
    }

    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($input_password, $user["password"])) {
            // 세션에 로그인 상태 및 사용자 ID 저장
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $input_username;
            $_SESSION["user_id"] = $user["id"]; // 사용자 ID를 세션에 저장

            echo "<script>
                    alert('로그인에 성공했습니다!');
                    window.location.href = 'kongkong1.php';
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

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KONGKONG 로그인</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css"> <!-- 로그인 CSS 파일 연결 -->
</head>
<body>
    <header>
        <h1><a href="kongkong1.php">KONGKONG</a></h1>
    </header>

    <main>
        <section class="login-section">
            <div class="container">
                <h2>로그인</h2>
                <form action="login.php" method="post" class="login-form">
                    <label for="username">아이디</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">비밀번호</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" class="btn">로그인</button>
                </form>
                <p class="register-link">계정이 없으신가요? <a href="register.php">회원가입</a></p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 KONGKONG. All rights reserved.</p>
    </footer>
</body>
</html>
