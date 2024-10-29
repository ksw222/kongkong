<?php
// Composer의 autoload 파일 로드 (절대 경로 사용)
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        // SMTP 설정
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com';
        $mail->Password = 'your_app_password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // 발신자 및 수신자 설정
        $mail->setFrom($email, $name);
        $mail->addAddress('example@example.com');

        // 메일 내용 설정
        $mail->isHTML(true);
        $mail->Subject = '새로운 문의가 도착했습니다';
        $mail->Body    = "<h3>이름: $name</h3><h3>이메일: $email</h3><p>$message</p>";
        $mail->AltBody = "이름: $name\n이메일: $email\n\n$message";

        $mail->send();
        echo "<script>alert('문의가 성공적으로 전송되었습니다.'); window.location.href = 'inquiry.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('메일 전송에 실패했습니다: {$mail->ErrorInfo}'); history.back();</script>";
    }
} else {
    echo "<script>alert('잘못된 접근입니다.'); window.location.href = 'inquiry.html';</script>";
}
?>
