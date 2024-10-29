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

// 게시글 ID 확인
$post_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$post_id) {
    echo "잘못된 접근입니다.";
    exit();
}

// 게시글 조회
$query = $conn->prepare("SELECT * FROM community_posts WHERE id = ?");
$query->bind_param('i', $post_id);
$query->execute();
$result = $query->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "해당 게시글을 찾을 수 없습니다.";
    exit();
}

// 조회수 증가
$conn->query("UPDATE community_posts SET views = views + 1 WHERE id = $post_id");

// 댓글 목록 조회
$comments = $conn->query("SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC");
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

    <header>
        <div class="container">
            <h1><a href="kongkong1.php">KONGKONG</a></h1>
            <nav>
                <ul>
                    <li><a href="Business_information.html">업무 안내</a></li>
                    <li><a href="chatbot_page.html">챗봇 상담</a></li>
                    <li><a href="community_main.php">커뮤니티</a></li>
                    <li><a href="inquiry.php">문의하기</a></li>
                    <li><a href="notification.html">공지사항</a></li>
                </ul>
            </nav>
        </div>
    </header>
<body>
<div class="post-content">
    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
    <div class="post-details">
        <span><strong>작성자:</strong> <?php echo htmlspecialchars($post['author'] ?? '알 수 없음'); ?></span>
        <span><strong>작성일:</strong> <?php echo $post['uploaded_at'] ?? '알 수 없음'; ?></span>
    </div>
    <div class="post-body">
        <p><?php echo nl2br(htmlspecialchars($post['content'] ?? '내용 없음')); ?></p>
        <?php if (!empty($post['filename']) && !empty($post['filepath'])): ?>
        <p><a href="<?php echo htmlspecialchars($post['filepath']); ?>" download="<?php echo htmlspecialchars($post['filename']); ?>">첨부파일 다운로드</a></p>
        <?php else: ?>
            <p>첨부된 파일이 없습니다.</p>
        <?php endif; ?>
    </div>
</div>

<div class="comment-section">
    <h3>댓글</h3>

    <!-- 댓글 목록 -->
    <div class="comments-container">
        <?php if ($comments->num_rows > 0): ?>
            <?php while ($comment = $comments->fetch_assoc()): ?>
                <div class="comment">
                    <p class="comment-author"><?php echo htmlspecialchars($comment['author']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                    <p class="comment-date"><?php echo $comment['created_at']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>댓글이 없습니다. 첫 댓글을 작성해보세요!</p>
        <?php endif; ?>
    </div>

    <!-- 댓글 작성 폼 -->
    <div class="comment-form">
        <form action="comment_post.php" method="POST">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <textarea class="comment-area" name="content" placeholder="댓글을 입력하세요..." required></textarea>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="comment-submit">댓글 작성</button>
                <button type="button" class="back-btn" onclick="history.back()">이전</button>
            </div>
        </form>
    </div>
</div>


</body>
</html>




<?php
$conn->close();
?>
