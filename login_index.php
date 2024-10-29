<?php
session_start();

if (isset($_GET['login']) && $_GET['login'] == 'success') {
    echo "<p>로그인 성공!</p>";
} else {
    echo "<p>로그인 실패. 다시 시도해주세요.</p>";
}

// 세션에 로그인 성공 여부가 저장되어 있다면
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // 메인 페이지로의 추가 처리 로직
    echo "<p>환영합니다!</p>";
}
?>
