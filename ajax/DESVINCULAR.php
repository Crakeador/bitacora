<?php
// Cambio de horario
include("../core/controller/Database.php");
session_start();

$base = new Database();
$con = $base->connect();

if($_GET['id'] == 0){
	$sql = "INSERT INTO horario (idservicio, idagente, dia, mes, ano, turno, tipo, created_at, usuario_log, ip) value 
								(".$_GET['servicio'].", ".$_GET['agente'].", \"".$_GET['dia']."\", \"".$_GET['mes']."\", \"".$_GET['ano']."\", ".$_GET['valor'].", 2, NOW(), '".$_SESSION['user_name']."', '".$_SESSION['ip']."')";
}else{
	$sql = "UPDATE horario SET turno=".$_GET['valor']." WHERE id=".$_GET['id'];
	$result = $con->query($sql);
}

if($result){
	if($_GET['valor'] == '10'){			
		$sql = "UPDATE person SET endwork=\"".$_GET['ano']."-".$_GET['mes']."-".$_GET['dia']."\", is_active=0 WHERE id=".$_GET['agente'];
		$result = $con->query($sql);
		$cadena = $sql;
		if($result){
			$sql = "UPDATE personpuestos SET is_active = 0 WHERE idservicio=".$_GET['servicio']." AND idperson=".$_GET['agente'];
			$result = $con->query($sql); 
			$cadena = $cadena.' '.$sql;
			
			//echo $cadena;
			if($result){
				//echo "<script>sweetAlert('Excelente', 'Se genero la nomina correctamente...!!!', 'success');</script>";
			}else{
				echo "<script>sweetAlert('Falla la actualizacion...!!!', '".$sql."', 'error');</script>";
			}
		}else{
			echo "<script>sweetAlert('Falla la actualizacion...!!!', '".$sql."', 'error');</script>";
		}
	}else{
		if($_GET['valor'] == '1'){	
			$sql = "UPDATE person SET endwork='0000-00-00', is_active=1 WHERE id=".$_GET['agente'];
			$result = $con->query($sql);
			$cadena = $sql;
			if($result){
				$sql = "UPDATE personpuestos SET is_active = 1 WHERE idservicio=".$_GET['servicio']." AND idperson=".$_GET['agente'];
				$result = $con->query($sql); 
				$cadena = $cadena.' '.$sql;
				
				//echo $cadena;			
				if($result){
					//echo "<script>sweetAlert('Excelente', 'Se genero la nomina correctamente...!!!', 'success');</script>";
				}else{
					echo "<script>sweetAlert('Falla la actualizacion...!!!', '".$sql."', 'error');</script>";
				}
			}else{
				echo "<script>sweetAlert('Falla la actualizacion...!!!', '".$sql."', 'error');</script>";
			}
		}
	}
}else{
	echo "<script>sweetAlert('Falla la actualizacion...!!!', '".$sql."', 'error');</script>";
}
