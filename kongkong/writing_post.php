<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";  // MySQL 비밀번호
$dbname = "kongkong_db";
$port = 3307;

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && isset($_POST['title'])) {
        $title = $_POST['title'];
        $author = "작성자";
        $content = $_POST['content'];
        $file = $_FILES['file_path'];  // 작성자 정보는 필요에 따라 추가할 수 있습니다.
        $uploadDate = date("Y-m-d"); // 오늘 날짜


        // 파일 업로드 경로 설정
        $uploadDirectory = "C:xampp\htdocs\kongkong\uploads";
        $uploadFile = $uploadDirectory . basename($file['name']);
        $filePath = $uploadDirectory . basename($file['name']);

        // 파일 업로드 처리
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            // 파일 정보 데이터베이스에 저장
            // 게시글을 데이터베이스에 삽입
            $sql = "INSERT INTO community_posts (title, author, content, file_path,  date, views) VALUES ('$title', '$author', '$content', '$file_path' ,'$date', 0)";
            $stmt->bind_param("ssss", $title, $author, $uploadDate, $filePath);

            if ($stmt->execute()) {
                echo "파일 업로드 및 저장 성공";
                header("Location: writing_post.php");
                exit(); // 리다이렉션 후 코드를 종료
            } else {
                echo "데이터베이스 저장 오류: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "파일 업로드 실패";
        }
    }
}


// 연결 종료
$conn->close();
?>
