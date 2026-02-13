<section id="main" role="main">
    <div class="row">
        <div class="col-md-10">
            <!-- Card Principal con diseño moderno -->
            <div class="box box-primary">            
                <div class="box-header with-border" style="text-align: center;">
                    <h3 class="box-title" style="font-size: 24px; font-weight: 600; color: #444; display: block;">
                        <i class="fa fa-qrcode" style="margin-right: 10px; color: #3c8dbc;"></i>Lector QR
                    </h3>
                    <p class="text-muted" style="margin-top: 10px; font-size: 14px;">
                        Activa la cámara para escanear códigos y acceder a enlaces.
                    </p>
                </div>            
                <div class="box-body" style="padding: 30px;">                
                    <!-- Contenedor de la Cámara -->
                    <div class="row" id="camera-row">
                        <div class="col-md-10 col-md-offset-1">
                            <div id="reader-container" style="position: relative; border-radius: 20px; overflow: hidden; background: #f0f0f0; min-height: 300px; display: flex; align-items: center; justify-content: center; border: 2px dashed #ccc;">
                                <div id="reader" style="width: 100%; height: 100%;"></div>
                                <div id="camera-placeholder" style="text-align: center; color: #888; position: absolute; width: 100%;">
                                    <i class="fa fa-camera" style="font-size: 64px; opacity: 0.5; margin-bottom: 15px;"></i>
                                    <p style="font-size: 16px; font-weight: 500;">La cámara está desactivada</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Controles de Cámara -->
                    <div class="row" id="controls-row" style="margin-top: 30px;">
                        <div class="col-md-12 text-center">
                            <button id="btn-start" class="btn btn-primary btn-lg btn-rounded shadow-btn" style="display: none;">
                                <i class="fa fa-play"></i> Activar Cámara
                            </button>
                            <button id="btn-stop" class="btn btn-danger btn-lg btn-rounded shadow-btn" style="display: none;">
                                <i class="fa fa-stop"></i> Detener
                            </button>
                        </div>
                    </div>
                    <!-- Tarjeta de Resultados (Oculta por defecto) -->
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-10 col-md-offset-1">
                            <div id="result-card" class="alert" style="display: none; border-radius: 15px; background-color: #e8f5e9; border: 1px solid #c3e6cb; color: #155724;">
                                <div style="text-align: center; padding: 10px;">
                                    <i class="fa fa-check-circle" style="font-size: 42px; color: #28a745; margin-bottom: 15px;"></i>
                                    <h4 style="font-weight: bold; margin-top: 0;">¡Código Detectado!</h4>
                                    
                                    <div style="background: #fff; padding: 15px; border-radius: 10px; margin: 15px 0; border: 1px solid #dee2e6; word-break: break-all;">
                                        <strong id="result-text" style="font-size: 16px; color: #333;"></strong>
                                    </div>
                                    
                                    <div id="action-buttons" style="margin-top: 20px;">
                                        <a id="btn-open-link" href="#" target="_blank" class="btn btn-success btn-lg btn-rounded shadow-btn" style="margin-right: 10px; margin-bottom: 5px;">
                                            <i class="fa fa-external-link"></i> Abrir Enlace
                                        </a>
                                        <button id="btn-copy" class="btn btn-default btn-lg btn-rounded shadow-btn" style="margin-bottom: 5px;">
                                            <i class="fa fa-copy"></i> Copiar Texto
                                        </button>
                                        <button id="btn-scan-again" class="btn btn-info btn-lg btn-rounded shadow-btn" style="margin-bottom: 5px;">
                                            <i class="fa fa-refresh"></i> Escanear Nuevo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* Estilos CSS personalizados para modernizar la interfaz */
    .btn-rounded {
        border-radius: 50px !important;
        padding: 10px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .shadow-btn {
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    .shadow-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }
    #reader video {
        border-radius: 15px;
        object-fit: cover;
    }
</style>

<script>
    // Inicialización de variables
    const html5QrCode = new Html5Qrcode("reader");
    const btnStart = document.getElementById('btn-start');
    const btnStop = document.getElementById('btn-stop');
    const cameraPlaceholder = document.getElementById('camera-placeholder');
    const resultCard = document.getElementById('result-card');
    const resultText = document.getElementById('result-text');
    const btnOpenLink = document.getElementById('btn-open-link');
    const btnCopy = document.getElementById('btn-copy');
    const cameraRow = document.getElementById('camera-row');
    const controlsRow = document.getElementById('controls-row');
    const btnScanAgain = document.getElementById('btn-scan-again');

    // Configuración del escáner
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    // Callback cuando se detecta un código
    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        // Detener escaneo automáticamente al encontrar código
        stopScanning();
        
        // Mostrar resultado
        resultText.innerText = decodedText;
        resultCard.style.display = 'block';
        cameraRow.style.display = 'none';
        controlsRow.style.display = 'none';
        
        // Verificar si es una URL válida para mostrar el botón de abrir
        if (isValidURL(decodedText)) {
            btnOpenLink.href = decodedText;
            btnOpenLink.style.display = 'inline-block';
        } else {
            btnOpenLink.style.display = 'none';
        }
    };

    // Función para iniciar el escaneo
    const startScanning = () => {
        resultCard.style.display = 'none';
        cameraPlaceholder.style.display = 'none';
        cameraRow.style.display = 'block';
        controlsRow.style.display = 'block';
        btnStart.style.display = 'none';
        btnStop.style.display = 'inline-block';

        // Usar cámara trasera ("environment") por defecto
        html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
        .catch(err => {
            console.error("Error al iniciar cámara", err);
            alert("No se pudo acceder a la cámara. Por favor verifique los permisos en su navegador.");
            stopScanning();
        });
    };

    // Evento Escanear Nuevo
    btnScanAgain.addEventListener('click', startScanning);

    // Evento Iniciar Cámara (para reiniciar si se detiene)
    btnStart.addEventListener('click', startScanning);

    // Evento Detener Cámara
    btnStop.addEventListener('click', () => {
        stopScanning();
    });

    // Función auxiliar para detener el escáner y resetear la UI
    function stopScanning() {
        html5QrCode.stop().then((ignore) => {
            cameraPlaceholder.style.display = 'block';
            btnStart.style.display = 'inline-block';
            btnStop.style.display = 'none';
        }).catch((err) => {
            console.log("Error al detener", err);
            // Si ya estaba detenido o hubo error, forzamos el estado de la UI
            cameraPlaceholder.style.display = 'block';
            btnStart.style.display = 'inline-block';
            btnStop.style.display = 'none';
        });
    }

    // Evento Copiar Texto
    btnCopy.addEventListener('click', () => {
        navigator.clipboard.writeText(resultText.innerText).then(function() {
            const originalHTML = btnCopy.innerHTML;
            btnCopy.innerHTML = '<i class="fa fa-check"></i> Copiado';
            btnCopy.classList.remove('btn-default');
            btnCopy.classList.add('btn-success');
            
            setTimeout(() => {
                btnCopy.innerHTML = originalHTML;
                btnCopy.classList.remove('btn-success');
                btnCopy.classList.add('btn-default');
            }, 2000);
        }, function(err) {
            console.error('Error al copiar: ', err);
        });
    });

    // Validación simple de URL
    function isValidURL(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;  
        }
    }

    // Iniciar automáticamente al cargar
    startScanning();
</script>
