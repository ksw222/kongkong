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

    <div class="write-post">
        <h2>게시글 작성 및 파일 업로드</h2>
        <form action="writing_post.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">작성자</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="content">내용</label>
                <textarea id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="file">파일 업로드</label>
                <input type="file" id="file" name="uploaded_file">
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">작성하기</button>
                <button type="reset" class="cancel-btn">취소</button>
            </div>
        </form>
    </div>
</body>
</html>
