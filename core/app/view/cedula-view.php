<form method="POST" action="/ocr-module/capture.php">
    <input type="hidden" name="camera_id" value="1">
    <button type="submit">Capturar Documento</button>
</form>

<button onclick="capturar()">📸 Capturar Documento</button>

<audio id="alerta" src="assets/media/alarma.mp3" preload="auto"></audio>
<audio id="ok" src="assets/media/siren.mp3" preload="auto"></audio>

<table border="1" id="resultados">
  <thead>
    <tr>
      <th>Fecha</th><th>Nombre</th><th>Cédula</th><th>F. Nacimiento</th><th>Estado</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<script>
    function capturar() {
        fetch('/ocr-module/capture.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'camera_id=1'
        })
        .then(res => res.json())
        .then(data => {
            if (!data.valido) {
            document.getElementById('alerta').play();
            alert("⚠️ Error: Faltan campos o cédula inválida");
            } else {
            document.getElementById('ok').play();
            }
            actualizarTabla();
        });
    }

    function actualizarTabla() {
        fetch('/ocr-module/frontend/fetch_results.php')
            .then(res => res.json())
            .then(data => {
            const tbody = document.querySelector('#resultados tbody');
            tbody.innerHTML = '';
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td>${row.creado_en}</td>
                <td>${row.nombre || '❌'}</td>
                <td>${row.cedula || '❌'}</td>
                <td>${row.fecha_nacimiento || '❌'}</td>
                <td>${(row.nombre && row.cedula && row.fecha_nacimiento) ? '✅' : '❌'}</td>
                `;
                tbody.appendChild(tr);
            });
        });
    }

    //setInterval(actualizarTabla, 5000); // Actualiza cada 5 segundos
    //actualizarTabla(); // Inicial
</script>
