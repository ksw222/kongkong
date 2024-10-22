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

// 게시글 목록 가져오기
$sql = "SELECT id, title, author, date, views FROM community_posts ORDER BY id DESC";
$result = $conn->query($sql);
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
            <h1><a href="kongkong1.html">KONGKONG</a></h1>
            <nav>
                <ul>
                    <li><a href="Business_information.html">업무 안내</a></li>
                    <li><a href="chatbot_page.html">챗봇 상담</a></li>
                    <li><a href="community_main.php">커뮤니티</a></li> <!-- 파일명을 PHP로 변경 -->
                    <li><a href="resource_page2.php">자료마당</a></li>
                    <li><a href="notification.html">공지사항</a></li>
                    <li><a href="login.html" class="login-btn">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="post-list">
            <h2>커뮤니티 게시글</h2>
            <table>
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>제목</th>
                        <th>작성자</th>
                        <th>날짜</th>
                        <th>조회수</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $row_number = 1; // 번호를 1부터 시작

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td><a href='community_view.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></td>";
                            echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['views'] . "</td>";
                            echo "</tr>";
                            $row_number++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>게시글이 없습니다.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="community_writing.html"><button class="write-btn">글쓰기</button></a>
            
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
$conn->close();
?>
