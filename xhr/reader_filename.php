<?php
	chdir('..');
	require_once 'conf/app.php';
	$class = new \docuprensa\reader\base;
	echo $class->filename();