	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>	
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
				<h1>Camara para Rondas</h1>
				<div class="col-sm-12">
					<video id="preview" class="p-1 border" style="width:100%;"></video>
				</div>
				<script type="text/javascript">
					var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
					scanner.addListener('scan',function(content){
						alert('Verificado: ' + content);
						window.location.href=content;
					});
					Instascan.Camera.getCameras().then(function (cameras){
						if(cameras.length>0){
							scanner.start(cameras[1]);
							$('[name="options"]').on('change',function(){
								if($(this).val()==1){
									if(cameras[0]!=""){
										scanner.start(cameras[0]);
									}else{
										alert('No hay camara principal...!!!');
									}
								}else if($(this).val()==2){
									if(cameras[1]!=""){
										scanner.start(cameras[1]);
									}else{
										alert('No hay camara auxiliar...!!!');
									}
								}
							});
						}else{
							console.error('No hay ninguna camara...!!!');
							alert('No hay ninguna camara.');
						}
					}).catch(function(e){
						console.error(e);
						alert(e);
					});
				</script>
				<!-- div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
				  <label class="btn btn-primary">
					<input type="radio" name="options" value="1" autocomplete="off"> Camera Principal
				  </label>
				  <label class="btn btn-secondary active">
					<input type="radio" name="options" value="2" autocomplete="off" checked> Camera Auxiliar
				  </label>
				</div -->
			</div>		
		</div>
	</div>	