// chatbot.js

// 초기 버튼 클릭 이벤트 리스너 설정
document.querySelectorAll(".option-button").forEach(button => {
    button.addEventListener("click", function() {
        let userInput = this.textContent;
        addUserMessage(userInput);
        setTimeout(function() {
            addBotMessage("현재 자동 응답만 지원됩니다. 곧 상담원이 연결됩니다.");
        }, 1000);
    });
});

document.getElementById("send-btn").addEventListener("click", function() {
    let userInput = document.getElementById("user-input").value;
    if (userInput.trim() !== "") {
        addUserMessage(userInput);
        document.getElementById("user-input").value = ""; // 입력창 초기화
        setTimeout(function() {
            addBotMessage("현재 자동 응답만 지원됩니다. 곧 상담원이 연결됩니다.");
        }, 1000);
    }
});

function addUserMessage(message) {
    let chatMessages = document.querySelector(".chat-messages");
    let userMessageDiv = document.createElement("div");
    userMessageDiv.classList.add("message", "user-message");
    userMessageDiv.textContent = message;
    chatMessages.appendChild(userMessageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function addBotMessage(message) {
    let chatMessages = document.querySelector(".chat-messages");
    let botMessageDiv = document.createElement("div");
    botMessageDiv.classList.add("message", "bot-message");
    botMessageDiv.textContent = message;
    chatMessages.appendChild(botMessageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
