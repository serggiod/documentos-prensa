<?php

	namespace docuprensa\biblioteca;
	use \PDO;
	use \PDOException;
	use \html;

	class base extends \docuprensa\main {

		public  $arrayGrid        = null;
		private $sqlDocFileAll    = "select fil_name name,fil_file file,fil_image image  from doc_file where fil_status='ACTIVO' order by fil_id asc;";
		private $sqlDocFileFiltro = "select fil_name name,fil_file file,fil_image image  from doc_file where fil_status='ACTIVO' and fil_name like '%:filtro%' order by fil_id asc;";

		public function getJsonGrid(){
			$this->init();
			$query = $this->dbPDO->query($this->sqlDocFileAll);
			$this->arrayGrid = $query->fetchAll(PDO::FETCH_ASSOC);
			return json_encode($this->arrayGrid);
			}

		public function filtro(){
			$this->init();
			$filtro = $this->sanitizeGetString('filtro');
			$sql = str_replace(':filtro',$filtro,$this->sqlDocFileFiltro);
			$query = $this->dbPDO->query($sql);
			$jsongrid = null;
			if($grid = $query->fetchAll(PDO::FETCH_ASSOC)){
				$jsongrid = json_encode($grid);
				}
			else{
				$jsongrid = '[]';
				} 
			unset($filtro);
			unset($sql);
			unset($query);
			return $jsongrid;
			}

		public function reset(){
			return $this->getJsonGrid();
			}
		
	}

	class grid extends \docuprensa\biblioteca\base {
		public function grid(){
			return $this->getJsonGrid();
			}
		public function miniatura(){
			$name = $this->sanitizeGetString('file');
			$file =	file_get_contents($this->basePath.'/tmb/'.$name);		
			return $file;
			}
	}


	
