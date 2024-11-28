<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";  // MySQL 비밀번호
$dbname = "kongkong_db";
$port = 3307;

// 오류 표시 설정
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// 업로드된 파일의 크기 제한 (바이트 단위)
$maxFileSize = 40 * 1024 * 1024; // 40MB

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 모든 필드가 전달됐는지 확인
    if (!empty($_POST['title']) && !empty($_POST['content']) && isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        // 폼 데이터 수신
        $title = htmlspecialchars($_POST['title']);
        $author = htmlspecialchars($_POST['author']);
        $content = htmlspecialchars($_POST['content']);
        $uploadDate = date("Y-m-d");
        $file = $_FILES['file'];

        // 파일 크기 확인
        if ($file['size'] > $maxFileSize) {
            echo "파일 크기가 40MB를 초과하여 업로드할 수 없습니다.";
            exit();
        }

        // 파일 업로드 경로 설정 및 고유한 파일명 생성
        $uploadDirectory = "C:/xampp/htdocs/kongkong/uploads/";
        $uniqueFileName = time() . '_' . basename($file['name']);
        $uploadFile = $uploadDirectory . $uniqueFileName;
        $filePath = "uploads/" . $uniqueFileName;

        // 디버깅용 파일 정보 출력
        echo "<pre>";
        var_dump($file);
        echo "</pre>";

        // 업로드 디렉터리가 있는지 확인하고 없으면 생성
        if (!is_dir($uploadDirectory)) {
            echo "업로드 디렉토리가 존재하지 않습니다. 디렉토리를 생성합니다...<br>";
            if (!mkdir($uploadDirectory, 0777, true)) {
                echo "업로드 디렉토리를 생성할 수 없습니다.";
                exit();
            }
        } else {
            echo "업로드 디렉토리가 이미 존재합니다.<br>";
        }

        // 디렉토리가 쓰기 가능 상태인지 확인
        if (!is_writable($uploadDirectory)) {
            echo "업로드 디렉토리에 쓰기 권한이 없습니다.";
            exit();
        } else {
            echo "업로드 디렉토리에 쓰기 권한이 있습니다.<br>";
        }

        // 파일 업로드 처리
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            echo "파일이 성공적으로 업로드되었습니다: $uploadFile<br>";

            // 데이터베이스에 게시글 정보 저장
            $stmt = $conn->prepare("INSERT INTO community_posts (title, author, content, file_path, date, views) VALUES (?, ?, ?, ?, ?, 0)");
            if ($stmt) {
                $stmt->bind_param("sssss", $title, $author, $content, $filePath, $uploadDate);

                if ($stmt->execute()) {
                    echo "<script>alert('글을 업로드하였습니다.'); window.location.href='community_main.php';</script>";
                } else {
                    echo "데이터베이스 저장 오류: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "SQL 준비 오류: " . $conn->error;
            }
        } else {
            echo "파일 업로드 실패. 다시 시도해주세요.<br>";
            // 권한 문제 진단
            if (!is_writable($uploadDirectory)) {
                echo " 업로드 디렉토리에 쓰기 권한이 없습니다.";
            } else {
                echo "파일 업로드 과정 중 알 수 없는 오류 발생.";
            }
        }
    } else {
        echo "제목, 내용 또는 파일이 누락되었습니다.";
        
        if (empty($_POST['title'])) echo "<br>제목이 비어 있습니다.";
        if (empty($_POST['content'])) echo "<br>내용이 비어 있습니다.";
        if (!isset($_FILES['file'])) echo "<br>파일이 설정되지 않았습니다.";
        else if ($_FILES['file']['error'] !== 0) echo "<br>파일 업로드 오류 코드: " . $_FILES['file']['error'];
    }
}

$conn->close();
?>
