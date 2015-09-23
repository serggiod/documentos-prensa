<?php

	// Iniciar session.
	session_start();

	// Obtener el path de la aplicacion. 
	$basePath = str_replace('/conf','',dirname(__FILE__));

	// Definir variables globales.
	define('baseUrl','');
	define('basePath',$basePath);
	define('eReporing','~E_ALL');

	// Definir comportamiento de la consola de errores.
	error_reporting(eReporing);

	// funci´on para administrar la captura de errores.
	function errorHandler($eNro,$eStr,$eFile,$eLine){
		$estr = array(
			'1' 	=>'E_ERROR',
			'2'	    =>'E_WARNING',
			'4'	    =>'E_PARSE',
			'8'	    =>'E_NOTICE',
			'16'	=>'E_CORE_ERROR',
			'32'	=>'E_CORE_WARNING',
			'64'	=>'E_COMPILE_ERROR',
			'128'	=>'E_COMPILE_WARNING',
			'256'	=>'E_USER_ERROR',
			'512'	=>'E_USER_WARNING',
			'1024' 	=>'E_USER_NOTICE',
			'2048' 	=>'E_STRICT',
			'4096' 	=>'E_RECOVERABLE_ERROR',
			'8192' 	=>'E_ALL'
		);

		// Requerir clases.
		require_once basePath.'/lib/class.html.php';
		require_once basePath.'/lib/module.main.php';
		require_once basePath.'/lib/module.backend.php';

		// Instaciar clases principales.
		$class = new \docuprensa\backend\authenticate;
		$tag   = new \html;
		$html  = null;

		if(eReporing=='E_ALL'){
			$html .= $tag->div('N&uacute;mero de error: '.$eNro.' ('.$estr[$eNro].')','msgError');
			$html .= $tag->div('Mensaje de error: '.$eStr,'msgError');
			$html .= $tag->div('Archivo de error: '.$eFile,'msgError');
			$html .= $tag->div('L&iacute;nea del error: '.$eLine,'msgError');
		}
		
		$html .= $class->form_login();
		echo $html;
		die;
	}

	// Establecer funcion que administrara la captura de errores.
	set_error_handler("errorHandler");

	// Escanear contenido del directorio de librerias.
	$F = scandir(basePath.'/lib/');
	unset($F[0]);
	unset($F[1]);

	// Cargar clase principal.
	require_once basePath.'/lib/module.main.php';

	// Cargar librerias de la aplicacion.
	foreach($F as $f){
		require_once basePath.'/lib/'.$f;
	}