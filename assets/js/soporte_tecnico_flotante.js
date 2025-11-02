document.addEventListener('DOMContentLoaded', function() {
    const chatContainerFlotante = document.getElementById('chat-container-flotante');
    const messageInputFlotante = document.getElementById('message-input-flotante');
    const sendButtonFlotante = document.getElementById('send-button-flotante');

    function addMessageFlotante(message, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
        messageDiv.style.marginBottom = '10px';
        messageDiv.style.padding = '8px';
        messageDiv.style.borderRadius = '5px';
        messageDiv.style.backgroundColor = isUser ? '#007bff' : '#f8f9fa';
        messageDiv.style.color = isUser ? 'white' : 'black';
        messageDiv.textContent = message;
        chatContainerFlotante.appendChild(messageDiv);
        chatContainerFlotante.scrollTop = chatContainerFlotante.scrollHeight;
    }

    function sendMessageFlotante() {
        const message = messageInputFlotante.value.trim();
        if (!message) return;

        addMessageFlotante(message, true);
        messageInputFlotante.value = '';

        sendButtonFlotante.disabled = true;
        sendButtonFlotante.textContent = 'Enviando...';

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
                addMessageFlotante('Error de API: ' + data.error.message);
            } else if (data.candidates && data.candidates[0] && data.candidates[0].content && data.candidates[0].content.parts && data.candidates[0].content.parts[0]) {
                const aiResponse = data.candidates[0].content.parts[0].text;
                addMessageFlotante(aiResponse);
            } else {
                addMessageFlotante('Lo siento, no pude procesar tu mensaje. Inténtalo de nuevo.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            addMessageFlotante('Error de conexión. Inténtalo de nuevo.');
        })
        .finally(() => {
            sendButtonFlotante.disabled = false;
            sendButtonFlotante.textContent = 'Enviar';
        });
    }

    sendButtonFlotante.addEventListener('click', sendMessageFlotante);
    messageInputFlotante.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessageFlotante();
        }
    });

    // Mensaje de bienvenida
    addMessageFlotante('¡Hola! Soy tu asistente de soporte técnico. ¿En qué puedo ayudarte hoy?');
});
