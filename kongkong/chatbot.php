<?php
// 에러 출력 설정
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. config.php에서 API 키 불러오기
    $config = include('config.php');
    $apiKey = $config['openai_api_key'];

    if (!$apiKey) {
        http_response_code(500);
        echo json_encode(['error' => 'API 키가 설정되지 않았습니다.']);
        exit;
    }

    // 2. 사용자로부터 받은 메시지와 카테고리 정보 파싱
    $postData = json_decode(file_get_contents('php://input'), true);
    $userMessage = $postData['message'] ?? '';
    $categories = $postData['categories'] ?? '카테고리 선택 없음';

    // 3. cURL 초기화 및 API 호출 설정
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ]);

    // 4. API 요청 데이터 구성
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => '당신은 층간소음 상담 챗봇입니다. 사용자로부터 소음 관련 카테고리 선택과 메시지를 받아 맞춤형 해결책을 제공합니다.'],
            ['role' => 'user', 'content' => "(카테고리 정보: {$categories}) {$userMessage}"]
        ],
        'temperature' => 0.7
    ];

    // 5. cURL로 API 요청 전송
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    // 6. 에러 처리
    if (curl_errno($ch)) {
        http_response_code(500);
        echo json_encode(['error' => 'OpenAI API 요청 중 오류가 발생했습니다.']);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    // 7. 응답 반환
    header('Content-Type: application/json');
    echo $response;
}
?>