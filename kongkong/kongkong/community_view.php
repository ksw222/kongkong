<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = ""; // XAMPP 기본 비밀번호
$dbname = "kongkong_db"; // 데이터베이스 이름
$port = 3307; // XAMPP에서 사용하는 MySQL 포트

// MySQLi 연결
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 게시글 아이디를 URL에서 가져오기
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($post_id == 0) {
    die("유효한 게시글 ID가 아닙니다.");
}

// Prepared Statement 사용하여 게시글 조회

$post_sql = "SELECT * FROM community_posts WHERE id = ?";
$stmt = $conn->prepare($post_sql);
$stmt->bind_param("i", $post_id);  // 정수형으로 바인딩
$stmt->execute();
$post_result = $stmt->get_result();

if ($post_result->num_rows > 0) {
    $post = $post_result->fetch_assoc();
} else {
    die("게시글을 찾을 수 없습니다.");
}

$created_at = isset($post['created_at']) ? $post['created_at'] : '작성일 없음';
    

// 댓글 작성 처리
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);
    $author = "사용자"; // 실제로는 로그인된 사용자 이름을 넣을 수 있음
    $comment_sql = "INSERT INTO comments (post_id, content, author) VALUES ('$post_id', '$comment', '$author')";
    if ($conn->query($comment_sql) === TRUE) {
        echo "댓글이 성공적으로 작성되었습니다.";
    } else {
        echo "댓글 작성 중 오류가 발생했습니다: " . $conn->error;
    }
}

// 해당 게시글의 댓글 조회
$comment_sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
$comment_result = $conn->query($comment_sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - KONGKONG 커뮤니티</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="community_main1.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="kongkong1.html">KONGKONG</a></h1>
            <nav>
                <ul>
                    <li><a href="Business_information.html">업무 안내</a></li>
                    <li><a href="chatbot_page.html">챗봇 상담</a></li>
                    <li><a href="community_main.php">커뮤니티</a></li>
                    <li><a href="resource_page2.php">자료마당</a></li>
                    <li><a href="notification.html">공지사항</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        
        <section class="post-content">
            <h2><?php echo htmlspecialchars($post['title']); ?></h2>
            <div class="post-details">
                <span>작성자: <?php echo htmlspecialchars($post['author']); ?></span>
                <span>날짜: <?php echo htmlspecialchars($created_at); ?></span>
                <span>조회수: <?php echo htmlspecialchars($post['views']); ?></span>
            </div>
            <div class="post-body">
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            </div>
        

        <section class="comment-section">
            <h3>댓글</h3>

            <!-- 댓글 목록 표시 -->
            <?php
            if ($comment_result->num_rows > 0) {
                while($comment = $comment_result->fetch_assoc()) {
                    echo "<div class='comment'>";
                    echo "<span class='comment-author'>" . htmlspecialchars($comment['author']) . "</span>";
                    echo "<span class='comment-date'>" . htmlspecialchars($comment['created_at']) . "</span>";
                    echo "<p>" . nl2br(htmlspecialchars($comment['content'])) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>댓글이 없습니다.</p>";
            }
            ?>

            <!-- 댓글 작성 폼 -->
            <div class="comment-form">
                <form action="" method="POST">
                    <textarea name="comment" class="comment-area" placeholder="댓글을 작성해주세요..." required></textarea><br>
                    <button type="submit" class="comment-submit">댓글 작성</button>
                    <button type="submit" class="comment-submit" onclick="window.location.href='community_main.php'">이전</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 KONGKONG. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php
// 데이터베이스 연결 종료
$conn->close();


?>
