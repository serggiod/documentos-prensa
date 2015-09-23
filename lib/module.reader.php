<?php

	namespace docuprensa\reader;
	use \PDO;
	use \PDOException;
	use \html;

	class base extends \docuprensa\main{
		private $sqlDocFileCount = "select count(*) from doc_file where fil_status='ACTIVO' order by fil_id asc limit 1;";
		private $sqlDocFileOne   = "select * from doc_file where fil_status='ACTIVO' order by fil_id asc limit 1;";

		public function filename(){
			$this->init();
			$query = $this->dbPDO->query($this->sqlDocFileCount);
			if($query->fetchColumn()){
				$query = $this->dbPDO->query($this->sqlDocFileOne);
				$docfile = $query->fetch(PDO::FETCH_OBJ);
				return $docfile->fil_file;
				}
			else{
				return 'white.pdf';
				}
			
			}
		}