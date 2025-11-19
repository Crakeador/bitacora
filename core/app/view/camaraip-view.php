<div class="wrapper">
  <section class="content">
    <div class="row mt-4">
      <div class="col-md-6">
        <img id="imagenCamara" src="uploads/ultima.jpg" class="img-fluid border" alt="imagen camara ip">
      </div>
      <div class="col-md-6">
        <form id="formularioOCR">
          <div class="form-group">
            <label>Cédula</label>
            <input type="text" id="cedula" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" id="nombre" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label>Apellido</label>
            <input type="text" id="apellido" class="form-control" readonly>
          </div>
          <button type="button" class="btn btn-primary" onclick="capturar()">Capturar</button>
        </form>
      </div>
    </div>
  </section>
</div>

<audio id="alerta" src="assets/media/alarma.mp3" preload="auto"></audio>
<audio id="ok" src="assets/media/siren.mp3" preload="auto"></audio>

<script>
    function capturar() {
    fetch('capture.php', { method: 'POST' })
        .then(res => res.json())
        .then(data => {
        document.getElementById('imagenCamara').src = 'uploads/ultima.jpg?' + new Date().getTime();
        document.getElementById('cedula').value = data.cedula || '';
        document.getElementById('nombre').value = data.nombre || '';
        document.getElementById('apellido').value = data.apellido || '';
        if (!data.valido) {
            document.getElementById('alerta').play();
            alert("⚠️ Error: Cédula inválida o campos incompletos");
        } else {
            document.getElementById('ok').play();
        }
        });
    }
</script>