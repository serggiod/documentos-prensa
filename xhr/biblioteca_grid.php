<?php
	chdir('..');
	require_once 'conf/app.php';
	$class = new \docuprensa\biblioteca\grid;
	header('Content-Type application/json');
	echo $class->grid();