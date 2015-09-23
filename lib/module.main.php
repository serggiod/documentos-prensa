<?php
	namespace docuprensa;
	use \html;
	use \PDO;
	use \PDOException;
	use \baseUrl;
	use \basePath;

	class main {

		public $baseUrl  = baseUrl;
		public $basePath = basePath;
		public $html 	 = null;
		public $dbPDO    = null;

		public function init(){
			$this->dbPDO = new PDO('sqlite:'.$this->basePath.'/db/documentos_prensa.sqlite',null,null,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
			$this->html  = new html();
			}

		public function sanitizeGetInt($key=null){
			$_GET[$key] = filter_var($_GET[$key],FILTER_SANITIZE_NUMBER_INT);
			if(!filter_var($_GET[$key],FILTER_VALIDATE_INT)){
				$_GET[$key] = null;
				}
			return $_GET[$key];
			}

		public function sanitizeGetString($key=null){
			$_GET[$key] = filter_var($_GET[$key],FILTER_SANITIZE_STRING);
			if(!filter_var($_GET[$key],FILTER_VALIDATE_REGEXP,array('options'=>array('regexp'=>'/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.\-\_]+$/')))){
				$_GET[$key] = null;
				}
			return utf8_encode($_GET[$key]);
			}

		public function sanitizePostInt($key=null){
			$_POST[$key] = filter_var($_POST[$key],FILTER_SANITIZE_NUMBER_INT);
			if(!filter_var($_POST[$key],FILTER_VALIDATE_INT)){
				$_POST[$key] = null;
				}
			return $_POST[$key];
			}

		public function sanitizePostString($key=null){
			$_POST[$key] = filter_var($_POST[$key],FILTER_SANITIZE_STRING);
			if(!filter_var($_POST[$key],FILTER_VALIDATE_REGEXP,array('options'=>array('regexp'=>'/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$/')))){
				$_POST[$key] = null;
				}
			return utf8_encode($_POST[$key]);
			}

		public function sanitizePostDate($key=null){
			$_POST[$key] = filter_var($_POST[$key],FILTER_SANITIZE_STRING);
			if(!filter_var($_POST[$key],FILTER_VALIDATE_REGEXP,array('options'=>array('regexp'=>'/^(0[1-9]|1[0-9]|2[0-9]|3[0-1])-(0[1-9]|1[0-2])-(19[7-9][0-9]|20[0-2][0-9])$/')))){
				$_POST[$key] = null;
				}
			return $_POST[$key];
			}

		public function msgError($msg=null){
			$html  = $this->html->div($msg,'msgError');
			return $html;
			}

		public function msgInfo($msg=null){
			$html  = $this->html->div($msg,'msgInfo');
			return $html;
			}

		public function msgSuccess($msg=null){
			$html = $this->html->div($msg,'msgSuccess');
			return $html;
			}

		public function msgAlert($msg=null){
			$html  = $this->html->div($msg,'msgAlert');
			return $html;
			}

		public function getUserLogin(){
			return $_SESSION['userLogin'];
			}
	}