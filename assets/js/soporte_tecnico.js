document.addEventListener('DOMContentLoaded', function() {
    const chatContainer = document.getElementById('chat-container');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');

    function addMessage(message, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
        messageDiv.style.marginBottom = '10px';
        messageDiv.style.padding = '8px';
        messageDiv.style.borderRadius = '5px';
        messageDiv.style.backgroundColor = isUser ? '#007bff' : '#f8f9fa';
        messageDiv.style.color = isUser ? 'white' : 'black';
        messageDiv.textContent = message;
        chatContainer.appendChild(messageDiv);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function sendMessage() {
        const message = messageInput.value.trim();
        if (!message) return;

        addMessage(message, true);
        messageInput.value = '';

        sendButton.disabled = true;
        sendButton.textContent = 'Enviando...';

        fetch('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=AIzaSyD7Ns24-K_SI22jQLXa-a5aXd15Yb_Xezo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                contents: [{
                    parts: [{
                        text: message
                    }]
                }]
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                addMessage('Error de API: ' + data.error.message);
            } else if (data.candidates && data.candidates[0] && data.candidates[0].content && data.candidates[0].content.parts && data.candidates[0].content.parts[0]) {
                const aiResponse = data.candidates[0].content.parts[0].text;
                addMessage(aiResponse);
            } else {
                addMessage('Lo siento, no pude procesar tu mensaje. Inténtalo de nuevo.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            addMessage('Error de conexión. Inténtalo de nuevo.');
        })
        .finally(() => {
            sendButton.disabled = false;
            sendButton.textContent = 'Enviar';
        });
    }

    sendButton.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Mensaje de bienvenida
    addMessage('¡Hola! Soy tu asistente de soporte técnico. ¿En qué puedo ayudarte hoy?');
});
