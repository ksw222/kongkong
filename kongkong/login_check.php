<?php
session_start(); // 세션 시작

// POST로 전달된 아이디와 비밀번호 받기
$username = $_POST['username'];
$password = $_POST['password'];

// 아이디가 숫자로만 이루어져 있는지 확인하는 정규 표현식
if (preg_match('/^\d+$/', $username)) {
    // 아이디가 숫자로만 이루어진 경우 로그인 실패 처리
    header("Location: login.php?login=fail");
    exit;
} else {
    // 그 외의 경우는 무조건 로그인 성공 처리
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;

    // 메인 페이지로 리다이렉트
    header("Location: kongkong1.php");
    exit;
}
?>