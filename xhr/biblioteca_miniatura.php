<?php
	chdir('..');
	require_once 'conf/app.php';
	$class = new docuprensa\biblioteca\grid;
	header('Content-Type image/jpg');
	echo $class->miniatura();
