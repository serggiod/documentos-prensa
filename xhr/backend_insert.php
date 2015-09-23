<?php
	chdir('..');
	require_once 'conf/app.php';
	$class = new \docuprensa\backend\base;
	if($class->getUserLogin()) echo $class->insert();