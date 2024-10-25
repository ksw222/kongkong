document.getElementById("send-btn").addEventListener("click", function () {
    let userInput = document.getElementById("user-input").value;
    if (userInput.trim() !== "") {
        const selectedCategories = getSelectedCategories(); // 선택된 카테고리 가져오기
        addUserMessage(`(카테고리: ${selectedCategories})\n${userInput}`);
        document.getElementById("user-input").value = ""; // 입력창 초기화
        sendMessageToServer(userInput, selectedCategories); // 서버로 메시지 전송
    }
});

function getSelectedCategories() {
    const noiseSources = Array.from(document.querySelectorAll('input[name="noise_source"]:checked'))
        .map(el => el.value).join(", ");
    const houseType = document.querySelector('input[name="house_type"]:checked')?.value || "선택 안 함";
    const damageTypes = Array.from(document.querySelectorAll('input[name="damage_type"]:checked'))
        .map(el => el.value).join(", ");
    return `소음원: [${noiseSources}], 주택 형태: [${houseType}], 피해 유형: [${damageTypes}]`;
}

function addUserMessage(message) {
    let chatMessages = document.querySelector(".chat-messages");
    let userMessageDiv = document.createElement("div");
    userMessageDiv.classList.add("message", "user-message");
    userMessageDiv.textContent = message;
    chatMessages.appendChild(userMessageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

async function sendMessageToServer(userInput, categories) {
    try {
        const response = await fetch("chatbot.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ message: userInput, categories: categories })
        });

        if (!response.ok) {
            throw new Error('서버 응답 오류'); // 응답이 정상적이지 않을 때 에러 던짐
        }

        const data = await response.json();
        addBotMessage(data.choices[0].message.content); // 서버로부터 받은 메시지 출력
    } catch (error) {
        addBotMessage('서버와의 통신에 문제가 발생했습니다.');
        console.error(error); // 콘솔에 에러 로그 출력
    }
}

function addBotMessage(message) {
    let chatMessages = document.querySelector(".chat-messages");
    let botMessageDiv = document.createElement("div");
    botMessageDiv.classList.add("message", "bot-message");
    botMessageDiv.textContent = message;
    chatMessages.appendChild(botMessageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
