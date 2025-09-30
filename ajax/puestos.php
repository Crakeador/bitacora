<?php 
/*
* Modulo de Operaciones para el registro del horaio de los agentes en puestos activos
* Modificado: 10/10/2023
*/
ini_set('max_input_vars', 5000);

Core::aviso();
if(count($_POST)>0){
	echo '<script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
	      <script type="text/javascript">
			swal("Excelente", "Se actualizaron los registros", "success");
		  </script>';
	foreach($_POST as $nombre_campo => $valor){
		if(strlen($valor)>6){
			$valor = explode("-", $valor);
			
			if($valor[0] == 0) {
				$user = new HorarioData();
				$user->idservicio = $valor[1];
				$user->idagente = $valor[2];
				$user->dia  = str_pad($valor[3], 2, "0", STR_PAD_LEFT);
				$user->mes  = str_pad($valor[4], 2, "0", STR_PAD_LEFT);
				$user->ano  = $valor[5];
				$user->turno= $valor[6];
				$user->tipo = 2;
				$user->add();
			}else{
				$user = new HorarioData();
				$user->id = $valor[0];
				$user->idservicio = $valor[1];
				$user->idagente = $valor[2];
				$user->dia  = str_pad($valor[3], 2, "0", STR_PAD_LEFT);
				$user->mes  = str_pad($valor[4], 2, "0", STR_PAD_LEFT);
				$user->ano  = $valor[5];
				$user->turno= $valor[6];
				$user->tipo = 2;
				$user->update();
			}
			if($valor[6]==10){				
				$final = new PersonData();	
				$fecha = $valor[5].'-'.str_pad($valor[4], 2, "0", STR_PAD_LEFT).'-'.str_pad($valor[3], 2, "0", STR_PAD_LEFT);
				$final->update_final($valor[0], $fecha);
				
				$desvincula = new PuestoData();	
				$desvincula->id = $valor[2];
				$desvincula->desvincular();
			}
		}
	}
}

Core::redir('rrhnom.lista');