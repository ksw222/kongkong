<?php
// 오류 표시 설정
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // 세션 시작

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kongkong_db";
$port = 3307;

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 세션에서 사용자 ID 가져오기
$userId = $_SESSION['user_id'] ?? null; // 세션에 저장된 사용자 ID 가져오기

// 사용자가 로그인되어 있는지 확인
if (!$userId) {
    echo "<script>alert('로그인이 필요합니다!'); window.location.href='login.html';</script>";
    exit();
}

// 사용자 정보 가져오기
$query = "SELECT nickname, email, username, name, age, birthdate, address, phone FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($nickname, $email, $username, $name, $age, $birthdate, $address, $phone);
$stmt->fetch();
$stmt->close(); // 연결 종료는 여기에 한 번만

// 업로드 성공 여부 메시지 초기화
$uploadMessage = "";

// 파일 업로드 처리
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file'];
        
        // 파일 업로드 경로 설정
        $uploadDirectory = 'uploads/';
        $uploadFile = $uploadDirectory . basename($file['name']);
        
        // 파일이 이미지인지 확인
        $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // 파일을 서버에 저장
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $uploadMessage = '파일 업로드 성공';
            } else {
                $uploadMessage = '파일 업로드 실패';
            }
        } else {
            $uploadMessage = '지원되지 않는 파일 형식입니다.';
        }
    } else {
        $uploadMessage = '파일이 선택되지 않았거나 오류가 발생했습니다.';
    }
}

$conn->close(); // 여기에 한 번만 위치하도록 조정

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>마이페이지</title>
    <link rel="stylesheet" href="styles.css"> <!-- 메인 페이지 CSS -->
    <link rel="stylesheet" href="mypage.css"> <!-- 마이페이지 CSS -->
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
                    <li><a href="resource_page2.php">자료마당</a></li>
                    <li><a href="notification.html">공지사항</a></li>
                </ul>
            </nav>
            <div class="buttons user-area">
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <a href="logout.php" class="logout-btn">로그아웃</a>
                <?php else: ?>
                    <a href="login.php" class="login-btn">로그인</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>마이페이지</h2>

        <!-- 파일 업로드 폼 -->
        <form action="mypage.php" method="post" enctype="multipart/form-data">
            <div class="profile-img" onclick="document.getElementById('profileImageInput').click();" style="cursor: pointer;">
                <input type="file" name="file" accept="image/*" onchange="previewImage(event)" style="display: none;" id="profileImageInput">
                <img id="profileImage" src="" alt="프로필 이미지 미리보기" style="display: none; border-radius: 10px; width: 100%; height: 100%; object-fit: cover;" />
                <span id="uploadText">프로필 이미지 업로드</span>
            </div>
        </form>

        <!-- 업로드 결과 메시지 출력 -->
        <?php if ($uploadMessage): ?>
            <p><?php echo $uploadMessage; ?></p>
        <?php endif; ?>

        <!-- 사용자 정보 표시 -->
        <div class="info-box">
            <div class="info-item">
                <label>닉네임:</label>
                <span><?php echo htmlspecialchars($nickname ?? "정보 없음"); ?></span>
            </div>
            <div class="info-item">
                <label>이메일:</label>
                <span><?php echo htmlspecialchars($email ?? "정보 없음"); ?></span>
            </div>
            <div class="info-item">
                <label>아이디:</label>
                <span><?php echo htmlspecialchars($username ?? "정보 없음"); ?></span>
            </div>
            <div class="info-item">
                <label>이름:</label>
                <span><?php echo htmlspecialchars($name ?? "정보 없음"); ?></span>
            </div>
            <div class="info-item">
                <label>나이:</label>
                <span><?php echo htmlspecialchars($age ?? "정보 없음"); ?></span>
            </div>
            <div class="info-item">
                <label>생년월일:</label>
                <span><?php echo htmlspecialchars($birthdate ?? "정보 없음"); ?></span>
            </div>
            <div class="info-item">
                <label>주소:</label>
                <span><?php echo htmlspecialchars($address ?? "정보 없음"); ?></span>
            </div>
            <div class="info-item">
                <label>전화번호:</label>
                <span><?php echo htmlspecialchars($phone ?? "정보 없음"); ?></span>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 KONGKONG. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const profileImage = document.getElementById('profileImage');
                const uploadText = document.getElementById('uploadText');
                
                profileImage.src = reader.result;
                profileImage.style.display = 'block'; // 이미지 표시
                uploadText.style.display = 'none'; // 텍스트 숨기기
            }
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>
