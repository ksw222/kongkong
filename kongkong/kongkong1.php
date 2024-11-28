<?php
session_start();  // 세션 시작

// 로그인 여부 확인
$loggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KONGKONG - 층간소음 해결방안</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- CSS 파일 연결 -->

    <script>
        // 페이지가 로드될 때 로그인 상태에 따라 버튼 변경
        window.onload = function () {
            const loginBtn = document.querySelector('.login-btn');
            const myPageBtn = document.querySelector('.mypage-btn'); // 마이페이지 버튼 선택
            const loggedIn = <?php echo json_encode($loggedIn); ?>;

            if (loggedIn) {
                loginBtn.textContent = '로그아웃';
                loginBtn.href = '#';
                loginBtn.onclick = handleLogout;

                // 마이페이지 버튼 활성화
                myPageBtn.style.display = 'inline-block';
                myPageBtn.href = 'mypage.php'; // 마이페이지 링크 설정
            } else {
                loginBtn.textContent = '로그인';
                loginBtn.href = 'login.php';

                // 마이페이지 버튼 비활성화
                myPageBtn.style.display = 'none';
            }
        };

        // 로그아웃 처리 함수
        function handleLogout(event) {
            event.preventDefault();
            if (confirm("로그아웃 하시겠습니까?")) {
                // 서버에 로그아웃 요청 보내기
                fetch('logout.php')
                    .then(response => response.text())
                    .then(data => {
                        alert('로그아웃 되었습니다.');
                        window.location.href = 'kongkong1.php'; // 로그아웃 후 페이지 새로고침
                    });
            }
        }
    </script>
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
            <div class="buttons">
                <a href="mypage.php" class="mypage-btn">마이페이지</a>
                <a href="login.php" class="login-btn">로그인</a>
            </div>
            <?php if ($loggedIn): ?>
                <div class="welcome-message">
                    <span><?php echo htmlspecialchars($_SESSION['username']); ?>님, 환영합니다!</span>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h2>층간소음, 이웃과의 문제 해결을 도와드립니다</h2>
                <p>층간소음으로 인한 불편을 줄이고, 원만한 해결을 도와드립니다.</p>
                <a href="chatbot_page.html" class="btn">챗봇 상담</a>
            </div>
        </section>

        <section class="solutions">
            <div class="container">
                <h2>층간소음 해결방안</h2>
                <div class="solution-item">
                    <h3>1. 소음 측정 서비스</h3>
                    <p>전문가가 직접 방문하여 소음을 측정하고, 결과를 바탕으로 해결 방안을 제시합니다.</p>
                </div>
                <div class="solution-item">
                    <h3>2. 중재 상담 서비스</h3>
                    <p>양쪽 이웃이 원만하게 문제를 해결할 수 있도록 중재 상담을 제공합니다.</p>
                </div>
                <div class="solution-item">
                    <h3>3. 법적 지원</h3>
                    <p>필요할 경우 법적 조치를 위한 지원을 제공합니다.</p>
                </div>
            </div>
        </section>

        <section class="contact">
            <div class="container">
                <h2>문의하기</h2>
                <form action="#" method="post">
                    <label for="name">이름</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">이메일</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">문의 내용</label>
                    <textarea id="message" name="message" required></textarea>

                    <button type="submit" class="btn">보내기</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 KONGKONG. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
