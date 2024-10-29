<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kongkong_db";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href = 'login.html';</script>";
    exit();
}

$username = $_SESSION['username'];

// DB에서 사용자 정보 가져오기
$stmt = $conn->prepare("SELECT nickname, email, username, name, age, birthdate, address, phone FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($nickname, $email, $username, $name, $age, $birthdate, $address, $phone);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>마이페이지</title>
    <link rel="stylesheet" href="mypage.css">
</head>
<body>
    <header>
        <nav>
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
                <a href="logout.php" class="login-btn">로그아웃</a>
                <a href="mypage.php" class="mypage-btn">마이페이지</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <h2>마이페이지</h2>

        <div class="profile-img">
            <input type="file" accept="image/*" onchange="previewImage(event)" style="display: none;" id="profileImageInput">
            <img id="profileImage" src="" alt="프로필 이미지 미리보기" style="display: none; border-radius: 10px; width: 100%; height: 100%; object-fit: cover;" />
            <div onclick="document.getElementById('profileImageInput').click();">
                <span>프로필 이미지 업로드</span>
            </div>
        </div>

        <div class="info-box">
            <div class="info-item">
                <label>닉네임:</label>
                <span><?php echo htmlspecialchars($nickname); ?></span>
            </div>
            <div class="info-item">
                <label>이메일:</label>
                <span><?php echo htmlspecialchars($email); ?></span>
            </div>
            <div class="info-item">
                <label>아이디:</label>
                <span><?php echo htmlspecialchars($username); ?></span>
            </div>
            <div class="info-item">
                <label>이름:</label>
                <span><?php echo htmlspecialchars($name); ?></span>
            </div>
            <div class="info-item">
                <label>나이:</label>
                <span><?php echo htmlspecialchars($age); ?></span>
            </div>
            <div class="info-item">
                <label>생년월일:</label>
                <span><?php echo htmlspecialchars($birthdate); ?></span>
            </div>
            <div class="info-item">
                <label>주소:</label>
                <span><?php echo htmlspecialchars($address); ?></span>
            </div>
            <div class="info-item">
                <label>전화번호:</label>
                <span><?php echo htmlspecialchars($phone); ?></span>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2024 KONGKONG. All rights reserved.</p>
    </footer>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const profileImage = document.getElementById('profileImage');
                profileImage.src = reader.result;
                profileImage.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>



