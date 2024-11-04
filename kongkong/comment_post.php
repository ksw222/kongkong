<?php
// 데이터베이스 연결 설정
$host = 'localhost';
$db = 'kongkong_db';
$user = 'root';
$pass = '';
$port = 3306;
$conn = new mysqli($host, $user, $pass, $db, $port);

// 연결 오류 확인
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// 폼 데이터 수집
$post_id = $_POST['post_id'];
$content = $_POST['content'];

// 댓글 데이터 삽입
$stmt = $conn->prepare("INSERT INTO comments (post_id, content) VALUES (?, ?)");
$stmt->bind_param('is', $post_id,  $content);

if ($stmt->execute()) {
    header("Location: community_view.php?id=$post_id"); // 상세 페이지로 리디렉션
    exit();
} else {
    echo '댓글 작성에 실패했습니다.';
}

$conn->close();
?>
