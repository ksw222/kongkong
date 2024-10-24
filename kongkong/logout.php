<?php
session_start();
session_unset(); // 세션 변수 해제
session_destroy(); // 세션 종료
header("Location: login.html"); // 로그인 페이지로 리디렉션
exit();
?>
