<?php
	chdir('..');
	require_once 'conf/app.php';
	$class = new \docuprensa\backend\authenticate;
	echo $class->login();