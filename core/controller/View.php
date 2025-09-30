<?php
// View.php
// @brief Una vista corresponde a cada componente visual dentro de un modulo.

class View {
	/**
	* @function load
	* @brief la funcion load carga una vista correspondiente a un modulo
	**/
	public static function load($view){
		// Module::$module;
		if(!isset($_GET['view'])){
			if(Core::$root==""){
				include "core/app/view/".$view."-view.php";
			}else if(Core::$root=="admin/"){
				include "core/app/".Core::$theme."/view/".$view."-view.php";
			}
		}else{
			if(View::isValid()){
				$url ="";
				if(Core::$root==""){
					$url = "core/app/view/".$_GET['view']."-view.php";
				}else if(Core::$root=="admin/"){
					$url = "core/app/".Core::$theme."/view/".$_GET['view']."-view.php";
				}
				include $url;
			}else{			
				//View::Error("</br><h1>No estoy seguro de que quieres hacer...!!!</h1></br><a href='./index.php?view=home'>Volver al inicio</a></br><img src='assets/images/404.png' alt+'Esto es un error...!!!' style='max-width:100%;width:auto;height:auto;'>");
				View::Error('<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Error
						<small>no hay pagina que mostrar</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
					</ol>
				</section>
				<section id="main" role="main" style="padding: 1.5rem !important;">
					<div class="callout callout-danger" style="margin-bottom: 0!important;">        
				        <h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
				        <div class="row">
				            <div class="col-md-4">
				            	<img src="assets/images/error.svg">
				            </div>
				            <div class="col-md-8">
				            	<h1>Lo sentimos. Tenemos problema para realizar esta opci&oacute;n.</h1></br>
				            	<p>Tenemos problemas para realizar esta &uacute;ltima acci&oacute;n. Puede intentar volver al <strong>Panel de Control</strong> para intentar volver a utilizar la opci&oacute;n.
				                ¿Todav&iacute;a no puede actualizar su requerimiento? A veces una opci&oacute;n causa el problema por que fue eliminada o actualizada por el administrador del sistema, 
				                verifique que la opci&oacute;n que necesita a&uacute;n esta activa y comuniquese con el administrador.
				                <a href="index.php?view=home" class="small-box-footer"><i class="fa fa-home"></i> Volver al Inicio</a>
				                </p>
				            </div>
				        </div>
				    </div>
				</section>');
			}
		}
	}

	/**
	* @function isValid
	* @brief valida la existencia de una vista
	**/
	public static function isValid(){
		$valid=false;
		if(isset($_GET["view"])){
			$url ="";
			if(Core::$root==""){
				$url = "core/app/view/".$_GET['view']."-view.php";
			}else if(Core::$root=="admin/"){
				$url = "core/app/".Core::$theme."/view/".$_GET['view']."-view.php";
			}
			if(file_exists($url)){
				$valid = true;
			}
		}
		return $valid;
	}

	public static function Error($message){
		print $message;
	}
}
