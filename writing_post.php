<?php
// 데이터베이스 연결 설정
$host = 'localhost';
$db = 'kongkong_db';
$user = 'root';
$pass = '';
$port = 3307;
$conn = new mysqli($host, $user, $pass, $db, $port);

// 연결 오류 확인
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// 폼 데이터 수집
$title = $_POST['title'];
$author = $_POST['author'];
$content = $_POST['content'];
$file = $_FILES['uploaded_file'];

// 파일 업로드 처리
$filename = null;
$filepath = null;

if ($file['error'] === UPLOAD_ERR_OK) {
    $filename = $file['name'];
    $filepath = 'C:\xampp\htdocs\uploads' . basename($filename);

    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        echo '파일 업로드 실패!';
        exit();
    }
}

// 게시글과 파일 정보를 데이터베이스에 저장
$stmt = $conn->prepare("INSERT INTO community_posts (title, author, content, filename, filepath) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $title, $author, $content, $filename, $filepath);

if ($stmt->execute()) {
    header('Location: community_main.php'); // 메인 페이지로 리디렉션
    exit();
} else {
    echo '게시글 저장에 실패했습니다.';
}

$conn->close();
?>
