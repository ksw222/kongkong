<?php
session_start();
session_destroy(); // 세션 종료
header("Location: kongkong1.php?logout=success"); // 메인 페이지로 리다이렉트, 로그아웃 성공 파라미터 추가
exit;
?>
