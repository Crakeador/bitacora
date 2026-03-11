<?php
session_start();
// ---
// la tarea de este archivo es eliminar todo rastro de cookie
// -- eliminamos el usuario
if(isset($_SESSION['user_id'])){
	unset($_SESSION['user_id']);
}

session_destroy();
echo '<script>
		console.log("Cerrando sesión...");
		localStorage.removeItem("usuario");
		localStorage.removeItem("puesto");
		localStorage.removeItem("ingreso");
		localStorage.removeItem("turno");
		localStorage.removeItem("verifica");
		localStorage.clear();
	
		window.location = "./";
	</script>';
// estemos donde estemos nos redirije al index
print "<script>window.location='./';</script>";
