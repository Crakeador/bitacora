<?php
// Pantalla para crear anuncios con múltiples fotos
date_default_timezone_set('America/Guayaquil');
$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; $_SESSION['guardar'] = 0; $observacion = ''; $estilo = ''; $mensaje = '';

// Listado de los puesto de servicio de los guardias
$puestos = PuestoData::getAll(2);

?>
<style>
.photo-upload-area {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background: #f9f9f9;
    transition: all 0.3s ease;
    cursor: pointer;
    margin-bottom: 15px;
}
.photo-upload-area:hover {
    border-color: #3c8dbc;
    background: #f0f8ff;
}
.photo-upload-area.dragover {
    border-color: #3c8dbc;
    background: #e6f3ff;
}
.photo-preview {
    display: inline-block;
    margin: 5px;
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.photo-preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
}
.photo-preview .remove-btn {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #f56954;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.camera-btn {
    background: linear-gradient(45deg, #3c8dbc, #357ca5);
    border: none;
    color: white;
    padding: 12px 20px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 5px;
}
.camera-btn:hover {
    background: linear-gradient(45deg, #357ca5, #2e6da4);
    transform: translateY(-2px);
}/*
.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
} 
.form-control {
    border-radius: 6px;
    border: 1px solid #ddd;
    padding: 12px;
    font-size: 16px;
    transition: border-color 0.3s ease;
} */
.form-control:focus {
    border-color: #3c8dbc;
    box-shadow: 0 0 0 2px rgba(60, 141, 188, 0.2);
}
.progress {
    height: 8px;
    border-radius: 4px;
    background: #f0f0f0;
    margin-top: 10px;
}
.progress-bar {
    background: linear-gradient(45deg, #3c8dbc, #357ca5);
    border-radius: 4px;
}
@media (max-width: 768px) {
    .photo-upload-area {
        padding: 15px;
        margin-bottom: 10px;
    }
    .photo-preview img {
        width: 80px;
        height: 80px;
    }
    .camera-btn {
        padding: 10px 15px;
        font-size: 12px;
        width: 100%;
        margin: 5px 0;
    }
    .form-control {
        padding: 10px;
        font-size: 16px; /* Evita zoom en iOS */
    }
}
</style>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-plus"></i> Ingreso del Parte</h3>
                </div>
                <form id="formAnuncio" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">                        
								<div class="form-group">
									<label class="control-label"> Fecha: <span class="text-danger">*</span></label>
									<div class="col-md-12 col-sm-12">
										<div class="input-group date form_datetime col-md-8 col-sm-8">
											<input class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
											<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
										</div>
									</div>
								</div>              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_localidad"> Puesto: <abbr title="Este campo es obligatorio" aria-label="required"><span class="text-danger">*</span></abbr></label>
                                    <?php
                                        echo '<select id="id_localidad" name="id_localidad" class="form-control">';
                                        foreach($puestos as $tables) {
                                            echo '<option value="'.$tables->id.'">'.$tables->descripcion.'</option>';
                                        }
                                        echo '</select>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">                        
                                <div class="form-group">
                                    <p>
                                        <fieldset>
                                            <legend>¿Que turno esta cubriendo?&nbsp;&nbsp;<abbr title="Este campo es obligatorio" aria-label="required"><span class="text-danger">*</span></abbr></legend>                                            
                                            <input type="radio" id="turno1" name="turno" value="1" checked="checked"> Diurno &nbsp;&nbsp;
                                            <input type="radio" id="turno2" name="turno" value="2"> Nocturno
                                        </fieldset>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="titulo">Título del Anuncio <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingrese el título del anuncio" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cuerpo">Contenido del Anuncio *</label>
                                    <textarea class="form-control" id="cuerpo" name="cuerpo" rows="5" placeholder="Escriba el contenido del anuncio aquí..." required></textarea>
                                    <small class="text-muted">Puede usar hasta 500 caracteres</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Fotografías (opcional)</label>
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i> 
                                        <strong>Geolocalización:</strong> Las fotos incluirán automáticamente la ubicación donde fueron tomadas.                                        
                                    </div>
                                    <input type="file" id="fotos" name="fotos[]" multiple accept="image/*" style="display: none;">
                                    
                                    <!-- Botones de cámara -->
                                    <div>
                                        <button type="button" class="camera-btn" onclick="capturePhoto()">
                                            <i class="fa fa-camera"></i> Tomar Foto
                                        </button>
                                    </div>
                                    
                                    <!-- Vista previa de fotos -->
                                    <div id="photoPreview" class="text-center" style="margin-top: 15px;"></div>
                                    
                                    <!-- Información de geolocalización -->
                                    <div id="locationInfo" class="alert alert-success" style="margin-top: 15px;">
                                        <i class="fa fa-map-marker"></i> 
                                        <strong>Ubicación capturada:</strong> 
                                        <span id="locationText"></span>
                                        <button type="button" class="btn btn-xs btn-default pull-right" onclick="showLocationOnMap()">
                                            <i class="fa fa-map"></i> Ver en Mapa
                                        </button>
                                    </div>
                                    
                                    <div id="uploadProgress" style="display: none;">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small class="text-muted">Subiendo fotos...</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="index.php?view=anuncios.admin" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Cancelar
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa fa-save"></i> Crear Anuncio
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedPhotos = [];
    let photoCounter = 0;
    let currentLocation = null;

    // Configurar drag & drop
    const uploadArea = document.querySelector('.photo-upload-area');
    const fileInput = document.getElementById('fotos');

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });

    // Manejar selección de archivos
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/') && selectedPhotos.length < 5) {
                addPhoto(file);
            }
        });
    }

    function addPhoto(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const photo = {
                id: photoCounter++,
                file: file,
                dataUrl: e.target.result,
                location: currentLocation ? {...currentLocation} : null
            };
            selectedPhotos.push(photo);
            updatePhotoPreview();
            updateLocationInfo();
        };
        reader.readAsDataURL(file);
    }

    function updatePhotoPreview() {
        const preview = document.getElementById('photoPreview');
        preview.innerHTML = '';
        
        selectedPhotos.forEach(photo => {
            const div = document.createElement('div');
            div.className = 'photo-preview';
            div.innerHTML = `
                <img src="${photo.dataUrl}" alt="Preview">
                <button type="button" class="remove-btn" onclick="removePhoto(${photo.id})">
                    <i class="fa fa-times"></i>
                </button>
                ${photo.location ? '<i class="fa fa-map-marker" style="position:absolute; bottom:5px; left:5px; color:#3c8dbc; font-size:12px;" title="Con ubicación"></i>' : ''}
            `;
            preview.appendChild(div);
        });
    }

    function updateLocationInfo() {
        const locationInfo = document.getElementById('locationInfo');
        const locationText = document.getElementById('locationText');
        
        if (currentLocation) {
            locationText.textContent = `${currentLocation.address || 'Ubicación actual'} (${currentLocation.lat.toFixed(6)}, ${currentLocation.lng.toFixed(6)})`;
            locationInfo.style.display = 'block';
        } else {
            locationInfo.style.display = 'none';
        }
    }

    function removePhoto(id) {
        selectedPhotos = selectedPhotos.filter(photo => photo.id !== id);
        updatePhotoPreview();
    }

    // Obtener ubicación actual
    function getCurrentLocation() {
        if (navigator.geolocation) {
            console.log('Cordenadas de las fotos');
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        accuracy: position.coords.accuracy
                    };
                    
                    // Obtener dirección usando geocoding inverso
                    reverseGeocode(currentLocation.lat, currentLocation.lng);
                    updateLocationInfo();
                },
                (error) => {
                    console.error('Error obteniendo ubicación:', error);
                    alert('No se pudo obtener la ubicación. Las fotos se guardarán sin coordenadas GPS.');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 300000 // 5 minutos
                }
            );
        } else {
            alert('Su navegador no soporta geolocalización.');
        }
    }

    // Geocoding inverso para obtener dirección
    async function reverseGeocode(lat, lng) {
        try {
            const response = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=es`);
            const data = await response.json();
            
            if (data.city && data.principalSubdivision) {
                currentLocation.address = `${data.city}, ${data.principalSubdivision}`;
                updateLocationInfo();
            }
        } catch (error) {
            console.error('Error obteniendo dirección:', error);
        }
    }

    // Mostrar ubicación en mapa
    function showLocationOnMap() {
        if (currentLocation) {
            const mapUrl = `https://www.google.com/maps?q=${currentLocation.lat},${currentLocation.lng}`;
            window.open(mapUrl, '_blank');
        }
    }

    // Capturar foto desde cámara
    function capturePhoto() {
        // Obtener ubicación antes de capturar
        getCurrentLocation();
        
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    // Crear modal para captura
                    const modal = document.createElement('div');
                    modal.className = 'modal fade';
                    modal.innerHTML = `
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Tomar Foto</h4>
                                </div>
                                <div class="modal-body text-center">
                                    <video id="camera" autoplay style="width: 100%; max-width: 400px;"></video>
                                    <canvas id="canvas" style="display: none;"></canvas>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="takeSnapshot()">
                                        <i class="fa fa-camera"></i> Capturar
                                    </button>
                                    <button type="button" class="btn btn-default" onclick="closeCamera()">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);
                    $(modal).modal('show');
                    
                    const video = modal.querySelector('#camera');
                    video.srcObject = stream;
                    
                    // Guardar stream globalmente
                    window.cameraStream = stream;
                })
                .catch(err => {
                    alert('No se pudo acceder a la cámara: ' + err.message);
                });
        } else {
            alert('Su navegador no soporta acceso a la cámara');
        }
    }

    function takeSnapshot() {
        const video = document.querySelector('#camera');
        const canvas = document.querySelector('#canvas');
        const context = canvas.getContext('2d');
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0);
        
        canvas.toBlob(blob => {
            const file = new File([blob], 'camera_photo.jpg', { type: 'image/jpeg' });
            addPhoto(file);
            closeCamera();
        }, 'image/jpeg', 0.8);
    }

    function closeCamera() {
        if (window.cameraStream) {
            window.cameraStream.getTracks().forEach(track => track.stop());
            window.cameraStream = null;
        }
        $('.modal').modal('hide');
        setTimeout(() => {
            document.querySelectorAll('.modal').forEach(modal => modal.remove());
        }, 500);
    }

    // Seleccionar de galería (simular)
    function selectFromGallery() {
        fileInput.click();
    }

    // Envío del formulario
    document.getElementById('formAnuncio').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        if (selectedPhotos.length === 0) {
            if (!confirm('No ha seleccionado ninguna foto. ¿Desea continuar sin fotos?')) {
                return;
            }
        }
        
        const formData = new FormData();
        formData.append('titulo', document.getElementById('titulo').value);
        formData.append('tipo', document.getElementById('tipo').value);
        formData.append('cuerpo', document.getElementById('cuerpo').value);
        
        // Agregar fotos con geolocalización
        selectedPhotos.forEach((photo, index) => {
            formData.append('fotos[]', photo.file);
            if (photo.location) {
                formData.append(`location_${index}`, JSON.stringify(photo.location));
            }
        });
        
        // Mostrar progreso
        document.getElementById('uploadProgress').style.display = 'block';
        const progressBar = document.querySelector('.progress-bar');
        
        try {
            const response = await fetch('index.php?view=anuncios.crear', {
                method: 'POST',
                body: formData
            });
            
            if (response.ok) {
                // Simular progreso
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10;
                    progressBar.style.width = progress + '%';
                    if (progress >= 100) {
                        clearInterval(interval);
                        setTimeout(() => {
                            window.location.href = 'index.php?view=anuncios.admin';
                        }, 500);
                    }
                }, 100);
            } else {
                throw new Error('Error al crear el anuncio');
            }
        } catch (error) {
            alert('Error: ' + error.message);
            document.getElementById('uploadProgress').style.display = 'none';
        }
    });

    // Validación en tiempo real
    document.getElementById('titulo').addEventListener('input', function() {
        if (this.value.length > 100) {
            this.value = this.value.substring(0, 100);
        }
    });

    document.getElementById('cuerpo').addEventListener('input', function() {
        if (this.value.length > 500) {
            this.value = this.value.substring(0, 500);
        }
        const remaining = 500 - this.value.length;
        const small = this.parentElement.querySelector('small');
        small.textContent = `${remaining} caracteres restantes`;
        small.className = remaining < 50 ? 'text-danger' : 'text-muted';
    });

    // Inicializar geolocalización al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        // Solicitar permisos de ubicación al cargar
        if (navigator.geolocation) {
            getCurrentLocation();
        }
    });
</script>
