<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KONGKONG 로그인</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <h1><a href="kongkong1.php">KONGKONG</a></h1>
    </header>

    <main>
        <section class="login-section">
            <div class="container">
                <h2>로그인</h2>

                <form action="login_check.php" method="post" class="login-form">
                    <label for="username">아이디</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">비밀번호</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" class="btn">로그인</button>
                </form>
                <p class="register-link">계정이 없으신가요? <a href="#">회원가입</a></p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 KONGKONG. All rights reserved.</p>
    </footer>

    <!-- 로그인 실패 시 JavaScript로 팝업 메시지 표시 -->
    <script>
        <?php if (isset($_GET['login']) && $_GET['login'] == 'fail'): ?>
            window.onload = function() {
                alert("아이디는 숫자로만 구성될 수 없습니다. 다시 시도해주세요.");
            }
        <?php endif; ?>
    </script>
</body>
</html>
