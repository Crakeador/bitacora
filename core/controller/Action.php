<?php

// 12 de Octubre del 2014
// Action.php
// @brief Un action corresponde a una rutina de un modulo.

class Action {
	/**
	* @function load
	* @brief la funcion load carga una vista correspondiente a un modulo
	**/
	public static function load($action){
		// Module::$module;

		if(!isset($_GET['action'])){
			include "core/app/action/".$action."-action.php";
		}else{
			if(Action::isValid()){
				include "core/app/action/".$_GET['action']."-action.php";
			}else{
				Action::Error("<img src='images/404.png' alt+'Esto es un error...!!!' style='max-width:100%;width:auto;height:auto;'></br><h1>La p&aacute;gina que intentas solicitar no esta en el servidor</h1></br><a href='./index.php?view=home'>Volver al inicio</a>");
			}
		}
	}

	/**
	* @function isValid
	* @brief valida la existencia de una vista
	**/
	public static function isValid(){
		$valid=false;
		if(file_exists($file = "core/app/action/".$_GET['action']."-action.php")){
			$valid = true;
		}
		return $valid;
	}

	public static function Error($message){
		print $message;
	}

	public function execute($action,$params){
		$fullpath =  "core/app/action/".$action."-action.php";
		if(file_exists($fullpath)){
			include $fullpath;
		}else{
			assert("wtf");
		}
	}
}
