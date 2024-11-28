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

// 게시글 목록 조회
$result = $conn->query("SELECT * FROM community_posts ORDER BY uploaded_at DESC");

// 쿼리 실행 오류 확인
if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KONGKONG 커뮤니티</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="community.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="kongkong1.php">KONGKONG</a></h1>
            <nav>
                <ul>
                    <li><a href="Business_information.html">업무 안내</a></li>
                    <li><a href="chatbot_page.html">챗봇 상담</a></li>
                    <li><a href="community_main.php">커뮤니티</a></li>
                    <li><a href="inquiry.html">문의하기</a></li>
                    <li><a href="notification.html">공지사항</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="post-list">
        <h2>커뮤니티 게시글</h2>
        <table>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>파일</th>
                <th>날짜</th>
                <th>조회수</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><a href="community_view.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></td>
                <td><?php echo htmlspecialchars($row['author']); ?></td>
                <td>
                    <?php if ($row['filename']): ?>
                        <a href="<?php echo $row['filepath']; ?>" download>다운로드</a>
                    <?php else: ?>
                        없음
                    <?php endif; ?>
                </td>
                <td><?php echo $row['uploaded_at']; ?></td>
                <td><?php echo $row['views']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <div class="form-actions">
            <a href="community_writing.php" class="submit-btn">글쓰기</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
