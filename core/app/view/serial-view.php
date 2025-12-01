<h1>Control de Acceso QR</h1>

<!-- Botón para conectar al dispositivo serial (requerido por la Web Serial API) -->
<button id="connectButton">Conectar Lector Serial</button>
<p>Estado: <span id="status">Desconectado</span></p>

<!-- Campo para mostrar el código leído (el escáner puede introducirlo automáticamente) -->
<label for="qrInput">Código QR:</label>
<input type="text" id="qrInput" readonly>

<div id="messageArea" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;">
    Esperando código...
</div>

<script>
    // --- PARTE JAVASCRIPT DEL CLIENTE ---

    const connectButton = document.getElementById('connectButton');
    const statusSpan = document.getElementById('status');
    const qrInput = document.getElementById('qrInput');
    const messageArea = document.getElementById('messageArea');
    let port;
    let reader;

    connectButton.addEventListener('click', async () => {
        if ('serial' in navigator) {
            try {
                // Solicitar al usuario que seleccione el puerto serial
                port = await navigator.serial.requestPort();
                // Abrir el puerto con la configuración adecuada (revisar la documentación del escáner)
                await port.open({ baudRate: 9600 }); // Ajusta baudRate si es necesario
                statusSpan.textContent = 'Conectado';
                readLoop();
            } catch (err) {
                console.error('Error al conectar:', err);
                statusSpan.textContent = 'Error de conexión';
            }
        } else {
            alert('Tu navegador no soporta la Web Serial API. Usa Chrome u Edge.');
        }
    });

    // Función para leer datos del puerto serial continuamente
    async function readLoop() {
        reader = port.readable.getReader();
        try {
            while (true) {
                const { value, done } = await reader.read();
                if (done) {
                    break;
                }
                // 'value' es un Uint8Array, convertir a texto
                const text = new TextDecoder().decode(value).trim();
                if (text.length > 0) {
                    handleQrCode(text);
                }
            }
        } catch (error) {
            console.error(error);
        } finally {
            reader.releaseLock();
        }
    }

    // Función para manejar el código QR leído
    function handleQrCode(code) {
        qrInput.value = code;
        messageArea.textContent = `Código leído: ${code}. Validando...`;
        // Enviar el código al backend PHP para validación
        validateCodeOnServer(code);
    }

    // Función para comunicarse con PHP mediante AJAX (Fetch API)
    async function validateCodeOnServer(code) {
        const formData = new FormData();
        formData.append('action', 'validate_qr');
        formData.append('qr_code', code);

        try {
            const response = await fetch('index.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                messageArea.style.color = 'green';
                messageArea.textContent = result.message;
                // Si el relé se controla desde el cliente (ver nota abajo), se haría aquí.
            } else {
                messageArea.style.color = 'red';
                messageArea.textContent = result.message;
            }
        } catch (error) {
            console.error('Error en la comunicación con el servidor:', error);
            messageArea.style.color = 'orange';
            messageArea.textContent = 'Error de comunicación con el servidor.';
        }
    }
    
    // *** NOTA SOBRE EL CONTROL DEL RELÉ ***
    // Si el relé está conectado al mismo PC que el lector QR (cliente),
    // la activación se haría aquí en JavaScript usando un 'writer' de la Web Serial API.
    /*
    async function activateRelayClientSide() {
         const writer = port.writable.getWriter();
         const data = new TextEncoder().encode("ACTIVAR\n"); // Comando para tu relé
         await writer.write(data);
         writer.releaseLock();
    }
    */
</script>