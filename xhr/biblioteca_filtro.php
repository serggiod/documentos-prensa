<?php

	chdir('..');
	require_once 'conf/app.php';
	$class = new \docuprensa\biblioteca\base;
	echo $class->filtro();