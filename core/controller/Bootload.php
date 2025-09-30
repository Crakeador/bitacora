<?php

// 10 de Octubre del 2014
// Bootload.php
// @brief esta clase sirve para alistar los boot

class Bootload {
	/**
	* @function load
	* @brief la funcion load carga un boot correspondiente a un modulo
	**/
	public static function load($view){
		// Module::$module;
		if(!isset($_GET['view'])){
			include "core/modules/".Module::$module."/boot/".$view."/boot-default.php";
		}else{
			if(self::isValid()){
				$fullpath = "core/modules/".Module::$module."/boot/".$_GET['view']."/boot-default.php";
				include $fullpath;
			}else{
				self::Error("<img src='images/404.png'></br><h1>La p&aacute;gina que intentas solicitar no esta en el servidor</h1></br><a href='./index.php?view=home'>Volver al inicio</a>");
			}
		}
	}

	/**
	* @function isValid
	* @brief valida la existencia de una vista
	**/
	public static function isValid(){
		$valid=false;
		if(file_exists($file = "core/modules/".Module::$module."/boot/".$_GET['view']."/boot-default.php")){
			$valid = true;
		}
		return $valid;
	}

	public static function Error($message){
		print $message;
	}
}
