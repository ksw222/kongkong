<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";  // MySQL 비밀번호
$dbname = "kongkong_db";
$port = 3307;

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 폼 데이터 받기
$title = $_POST['title'];
$author = $_POST['author'];
$content = $_POST['content'];
$date = date("Y-m-d");  // 현재 날짜

// 게시글을 데이터베이스에 삽입
$sql = "INSERT INTO community_posts (title, author, content, date, views) VALUES ('$title', '$author', '$content', '$date', 0)";

if ($conn->query($sql) === TRUE) {
    // 삽입 성공 시 목록 페이지로 이동
    header("Location: community_main.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 연결 종료
$conn->close();
?>
