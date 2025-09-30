<?php
// Esta funcion elimina el hecho de estar agregando los modelos manualmente

if(!function_exists('classAutoLoader')){
	function classAutoLoader($modelname){
		if(Model::exists($modelname)){
			include Model::getFullPath($modelname);
		}
	}
}

spl_autoload_register('classAutoLoader');

/*
function __autoload($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
	}
}
*/