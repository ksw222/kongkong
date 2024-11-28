<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);



$servername = "localhost";
$username = "root";
$password = ""; // XAMPP 기본 비밀번호
$dbname = "kongkong_db"; // 데이터베이스 이름
$port = 3307;

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> KONGKONG 자료마당</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="resources.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="kongkong1.php">KONGKONG</a></h1>
            <nav>
                <ul>
                    <li><a href="kongkong1.html">업무 안내</a></li>
                    <li><a href="chatbot_page.html">챗봇 상담</a></li>
                    <li><a href="community_main.html">커뮤니티</a></li>
                    <li><a href="resource_page2.php">자료마당</a></li>
                    <li><a href="notification.html">공지사항</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="resources-list">
            <h2>자료마당</h2>
            <table>
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>자료 제목</th>
                        <th>작성자</th>
                        <th>날짜</th>
                        <th>파일</th>
                        <th>조회수</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, title, author, upload_date, file_path, views FROM resources ORDER BY id DESC";
                    $result = $conn->query($sql);
                    $row_number = 1; // 번호를 1부터 시작

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_number . "</td>"; // 번호 출력
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['upload_date']) . "</td>";
                            echo "<td><a href='download.php?id=" . $row['id'] . "' download>다운로드</a></td>";
                            echo "<td>" . $row['views'] . "</td>";
                            echo "</tr>";
                            $row_number++; // 다음 번호로 증가
                        }
                    } else {
                        echo "<tr><td colspan='6'>자료가 없습니다.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section class="upload-section">
            <h2>자료 업로드</h2>
            <form action="resources_1.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">자료 제목</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="file">파일 선택</label>
                    <input type="file" id="file" name="file" required>
                </div>
                <button type="submit" class="submit-btn">업로드</button>
            </form>
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
