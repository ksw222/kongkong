<?php
session_start();
$loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KONGKONG - 메인 페이지</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1><a href="/kongkong/kongkong1.php">KONGKONG</a></h1> <!-- 절대 경로로 수정 -->
        <nav>
            <ul>
                <li><a href="Business_information.html">업무 안내</a></li>
                <li><a href="chatbot_page.html">챗봇 상담</a></li>
                <li><a href="community_main.html">커뮤니티</a></li>
                <li><a href="resources_page.html">자료마당</a></li>
                <li><a href="notification.html">공지사항</a></li>
            </ul>
        </nav>
        <div>
            <!-- 로그인 상태에 따라 로그인/로그아웃 버튼 표시 -->
            <?php if ($loggedin): ?>
                <a href="logout.php" class="login-btn">로그아웃</a>
            <?php else: ?>
                <a href="login.php" class="login-btn">로그인</a>
            <?php endif; ?>
        </div>
    </header>

    <script>
        <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
            alert("로그아웃되었습니다.");
        <?php endif; ?>
    </script>

    <main>
        <section class="hero">
            <div class="container">
                <h2>층간소음, 이웃과의 문제 해결을 도와드립니다</h2>
                <p>층간소음으로 인한 불편을 줄이고, 원만한 해결을 도와드립니다.</p>
                <a href="#" class="btn">챗봇 상담</a>
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