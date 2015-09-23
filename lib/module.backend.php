<?php

	namespace docuprensa\backend;
	use \html;
	use \PDO;
	use \PDOException;

	class form extends \docuprensa\main {
		public function fil_id($field=array(null,null)){ $this->init(); return $this->html->input('hidden','id',$field[0],$field[1]); }
		public function fil_name($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Titulo:</label>'.$this->html->input('text','name',$field[0],'required autofocus placeholder:"Titulo del Documento";title:"Ingrese correctamente el titulo del documento.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$"'.$field[1]); }
		public function fil_description($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descripci&oacute;n:</label>'.$this->html->textarea('description',$field[0],'required placeholder:"Descripcion del documento";title:"Ingrese correctamente la descripcion del documento.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$"'.$field[1]); }
		public function fil_keyword($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Palabras Claves:</label>'.$this->html->input('text','keyword',$field[0],'required placeholder:"palabra1, palabra2";title:"Ingrese correctamente las palabras claves.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$"'.$field[1]); }
		public function fil_author($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Autor:</label>'.$this->html->input('text','author',$field[0],'required placeholder:"Nombre del autor";title:"Ingrese correctamente el nombre del autor.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$"'.$field[1]); }
		public function fil_editor($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Editorial:</label>'.$this->html->input('text','editor',$field[0],'required placeholder:"Nombre de la editorial";title:"Ingrese correctamente el nombre de la editorial.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$"'.$field[1]); }
		public function fil_date_publish($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha de Publicaci&oacute;n:</label>'.$this->html->input('date','publish',$field[0],'required placeholder:"'.date('d-m-Y').'";title:"Ingrese en forma correcta la fecha de publicacion del documento.";pattern:"^(0[1-9]|1[0-9]|2[0-9]|3[0-1])-(0[1-9]|1[0-2])-(19[7-9][0-9]|20[0-2][0-9])$"'.$field[1]); }
		public function fil_pages($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P&aacute;ginas:</label>'.$this->html->input('number','pages',$field[0],'required placeholder:"1";title:"Ingrese en forma correcta el numero de paginas.";pattern:"^\d+$"'.$field[1]); }
		public function fil_type($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo:</label>'.$this->html->input('text','type',$field[0],'required paceholder:"Libro Scaneado";title:"Ingrese en forma correcta el tipo.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$"'.$field[1]); }
		public function fil_formato($field=array(null,null)){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Formato:</label>'.$this->html->input('text','formato',$field[0],'required placeholder:"A4";title:"Ingrese en forma correcta el formato.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$"'.$field[1]); }
		public function fil_file(){ $this->init(); return '<label id="fnlabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Archivo:</label>'.$this->html->input('file','file'); }
		}

	class base extends \docuprensa\main {

		private $sqlDocFileAll    = "select * from doc_file";
		private $sqlDocFileOne	  = "select * from doc_file where fil_id=:fil_id;";
		private $sqlDocFileOder   = " order by fil_id desc";
		private $sqlDocFileInsert = "insert into doc_file (fil_name,fil_description,fil_keyword,fil_author,fil_editor,fil_date_publish,fil_date_insert,fil_pages,fil_type,fil_file,fil_image,fil_mime,fil_formato,fil_status) VALUES (':name',':description',':keyword',':author',':editor',':publish',':insert',':pages',':type',':file',':image',':mime',':formato',':status');";
		private $sqlDocFileDelete = "delete from doc_file where fil_id=:fil_id limit 1;";
		private $sqlDocFileStatus = "update doc_file set fil_status=':fil_status' where fil_id=:fil_id;";
		private $sqlDocFileUpdate = "update doc_file set fil_name=':fil_name',fil_description=':fil_description',fil_keyword=':fil_keyword',fil_author=':fil_author',fil_editor=':fil_editor',fil_date_publish=':fil_date_publish',fil_pages=':fil_pages',fil_type=':fil_type',fil_formato=':fil_formato' where fil_id=:fil_id;";
	
		public function grid(){
			$this->init();
			$html  = $this->html->h2('Documentos de la Direcci&oacute;n de Prensa','formTitle');
			$html .= $this->msgInfo('Lista de documentos que se han publicados hasta la fecha.');
			$html .= $this->baseGrid();
			return $html;
			}

		public function baseGrid(){
			$this->init();
			$sql    = $this->sqlDocFileAll;
			$sql   .= $this->sqlDocFileOder;
			$sql   .= ";";
			$query  = $this->dbPDO->prepare($sql);
			$query->execute();

			$tbuts  = $this->html->a('Recargar','javascript: window.backend.form_grid();',null,'formButton');
			$tbuts .= $this->html->a('Nuevo','javascript: window.backend.form_nuevo();',null,'formButton');
			$tbuts .= $this->html->a('Visualizar','javascript: window.backend.form_visualizar();',null,'formButton');
			$tbuts .= $this->html->a('Modificar','javascript: window.backend.form_modificar();',null,'formButton');
			$tbuts .= $this->html->a('Eliminar','javascript: window.backend.form_eliminar();',null,'formButton');
			$tbuts .= $this->html->a('Estado','javascript: window.backend.form_estado();',null,'formButton');
			$tbuts .= $this->html->a('Salir','javascript: window.backend.logout();',null,'formButton');

			$celh   = $this->html->div('ID','celh','class:"width30";');
			$celh  .= $this->html->div('NOMBRE','celh','class:"widthAuto";');
			$celh  .= $this->html->div('AUTOR','celh','class:"width200";');
			$celh  .= $this->html->div('CARGA','celh','class:"width120";');
			$celh  .= $this->html->div('ESTADO','celh','class:"width120";');
			$celH   = $this->html->div($celh,'celH');
			
			$celR   = null;
			foreach($query->fetchAll(PDO::FETCH_OBJ) as $file){
				$celr  = null;
				$celr .= $this->html->div($file->fil_id,'celr','class:"width30";');
				$celr .= $this->html->div($file->fil_name,'celr','class:"widthAuto";');
				$celr .= $this->html->div($file->fil_author,'celr','class:"width200";');
				$celr .= $this->html->div($file->fil_date_insert,'celr','class:"width120";');
				$celr .= $this->html->div($file->fil_status,'celr','class:"width120";');
				$celR .= $this->html->div($celr,'celR','onclick: window.backend.id='.$file->fil_id.';');
				}

			$html  = $this->html->div($tbuts,'formToolbar');
			$html .= $this->html->div($celH.$celR,'formGrid');

			return $html;
			}

		public function formNuevo(){
			$this->init();
			$form  = new \docuprensa\backend\form;
			$html  = $this->html->h2('Nuevo Documento','formTitle');
			$html .= $this->msgInfo('Complete el formulario para ingresar un nuevo documento.');
			$html .= $this->html->br();
			
			$html .= '<form id="formulario" name="formulario" action="'.$this->baseUrl.'/xhr/backend_insert.php" target="formNuevoIfr" method="POST" enctype="multipart/form-data">';
			$html .= $form->fil_name(array(null,'maxlength:"60"'));
			$html .= $form->fil_description(array(null,null));
			$html .= $form->fil_keyword(array(null,'maxlength:"60"'));
			$html .= $form->fil_author(array(null,'maxlength:"50"'));
			$html .= $form->fil_editor(array(null,'maxlength:"50"'));
			$html .= $form->fil_date_publish(array(null,'maxlength:"10"'));
			$html .= $form->fil_pages(array(null,'maxlength:"5"'));
			$html .= $form->fil_file();
			$html .= $this->html->a('Aceptar','javascript: window.backend.button_submit()',null,'buttonSubmit');
			$html .= $this->html->a('Cancelar','javascript: window.backend.button_cancel()',null,'buttonCancel');
			$html .= '</form>';
			$html .= '<iframe id="formNuevoIfr" name="formNuevoIfr"></iframe>';
			
			return $html;
			}

		public function formVisualizar(){
			$this	 ->init();
			$form    = new \docuprensa\backend\form;;
			$fil_id  = $this->sanitizeGetInt('id');
			$sql     = str_replace(':fil_id',$fil_id,$this->sqlDocFileOne);
			$query   = $this->dbPDO->query($sql);
			$data    = $query->fetch(PDO::FETCH_OBJ);

			$html    = $this->html->h2('Visualizar Archivo','formTitle');
			$html   .= $this->msgAlert('Visualizando detalles de un archivo');
			$html   .= $this->html->br();
			
			$html 	.= '<form id="formulario" name="formulario" target="formNuevoIfr" method="POST" enctype="multipart/form-data">';
			$html 	.= $form->fil_name(array($data->fil_name,'maxlength:"60";readonly:"readonly"'));
			$html 	.= $form->fil_description(array($data->fil_description,'readonly:"readonly"'));
			$html 	.= $form->fil_keyword(array($data->fil_keyword,'maxlength:"60";readonly:"readonly"'));
			$html 	.= $form->fil_author(array($data->fil_author,'maxlength:"50";readonly:"readonly"'));
			$html 	.= $form->fil_editor(array($data->fil_author,'maxlength:"50";readonly:"readonly"'));
			$html 	.= $form->fil_date_publish(array($data->fil_date_publish,'maxlength:"10";readonly:"readonly"'));
			$html 	.= $form->fil_pages(array($data->fil_pages,'maxlength:"5";readonly:"readonly"'));
			$html 	.= $this->html->a('Aceptar','javascript: window.backend.button_cancel()',null,'buttonSubmit');
			$html 	.= '</form>';

			return $html;			
			}

		public function formModificar(){
			$this	 ->init();
			$form    = new \docuprensa\backend\form;
			$fil_id  = $this->sanitizeGetInt('id');
			$sql     = str_replace(':fil_id',$fil_id,$this->sqlDocFileOne);
			$query   = $this->dbPDO->query($sql);
			$data    = $query->fetch(PDO::FETCH_OBJ);

			$html    = $this->html->h2('Visualizar Archivo','formTitle');
			$html   .= $this->msgAlert('Modificando los detalles  de un archivo.');
			$html   .= $this->html->br();

			$html 	.= '<form id="formulario" name="formulario" action="'.$this->baseUrl.'/xhr/backend_update.php" target="formNuevoIfr" method="POST" enctype="multipart/form-data">';
			$html 	.= $form->fil_id(array($fil_id,null));
			$html 	.= $form->fil_name(array($data->fil_name,'maxlength:"60"'));
			$html 	.= $form->fil_description(array($data->fil_description,null));
			$html 	.= $form->fil_keyword(array($data->fil_keyword,'maxlength:"60"'));
			$html 	.= $form->fil_author(array($data->fil_author,'maxlength:"50"'));
			$html 	.= $form->fil_editor(array($data->fil_author,'maxlength:"50"'));
			$html 	.= $form->fil_date_publish(array($data->fil_date_publish,'maxlength:"10"'));
			$html 	.= $form->fil_pages(array($data->fil_pages,'maxlength:"5"'));
			$html   .= $this->html->a('Aceptar','javascript: window.backend.button_submit()',null,'buttonSubmit');
			$html   .= $this->html->a('Cancelar','javascript: window.backend.button_cancel()',null,'buttonCancel');
			$html   .= '</form>';
			$html   .= '<iframe id="formNuevoIfr" name="formNuevoIfr"></iframe>';

			return $html;			
			}

		public function insert(){
			$this->init();
			if(isset($_FILES)){

				$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
			    $mime  = finfo_file($finfo,$_FILES['file']['tmp_name']);
			    finfo_close($finfo);

			    $k = array("'",'"','~','#','@','|','^','&','$','*','+','[',']','(',')',' ','-','ñ','á','é','í','ó','ú','à','è','ì','ò','ù','ü');
			    $w = array('_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','n','a','e','i','o','u','a','e','i','o','u','u');
			    $_FILES['file']['name'] = utf8_encode($_FILES['file']['name']);
			    $_FILES['file']['name'] = strtolower($_FILES['file']['name']);
			    $_FILES['file']['name'] = str_replace($k,$w,$_FILES['file']['name']);
			    $_FILES['file']['name'] = date('dmyhis').$_FILES['file']['name'];

				if($_FILES['file']['error']==0){
					if($_FILES['file']['type']=='application/pdf' && $mime=='application/pdf'){
						if(move_uploaded_file($_FILES['file']['tmp_name'],$this->basePath.'/pdfs/'.$_FILES['file']['name'])) {

							$name 		 = $this->sanitizePostString('name');
							$description 	 = $this->sanitizePostString('description');
							$keyword 	 = $this->sanitizePostString('keyword');
							$author 	 = $this->sanitizePostString('author');
							$editor 	 = $this->sanitizePostString('editor');
							$publish 	 = $this->sanitizePostDate('publish');
							$insert 	 = date('d-m-Y');
							$pages 		 = $this->sanitizePostInt('pages');
							$type 		 = null;
							$formato 	 = null;
							$file  		 = $_FILES['file']['name'];
							$image 		 = $_FILES['file']['name'].'.jpg';
							$mime 		 = $_FILES['file']['type'];
							$status 	 = 'INACTIVO';
				
							exec('convert "'.$this->basePath.'/pdfs/'.$_FILES['file']['name'].'[0]" -thumbnail 300 '.$this->basePath.'/tmb/'.$_FILES['file']['name'].'.jpg');

							chmod($this->basePath.'/pdfs/'.$_FILES['file']['name'],0444);
							chmod($this->basePath.'/tmb/'.$_FILES['file']['name'].'.jpg',0444);

							$sql = str_replace(
								array(':name',':description',':keyword',':author',':editor',':publish',':insert',':pages',':type',':file',':image',':mime',':formato',':status'),
								array($name,$description,$keyword,$author,$editor,$publish,$insert,$pages,$type,$file,$image,$mime,$formato,$status),
								$this->sqlDocFileInsert
								);

							$query = $this->dbPDO->prepare($sql);
							$query->execute();

							if($query->rowCount()){
								$html = '<script> window.parent.backend.form_grid(); </script>';	
								} 
							else{
								$html = '<script> window.parent.alert("Se detecto 5 errores consulte al Centro de Computos."); </script>';
								}

							} 
						else{
							$html = '<script> window.parent.alert("Se detecto 4 errores al Centro de Computos."); </script>';
							}
						} 
					else{
						$html = '<script> window.parent.alert("Se detecto 3 errores consulte al Centro de Computos."); </script>';
						}
					} 
				else{
					$html = '<script> window.parent.alert("Se detecto 2 errores consulte al Centro de Computos."); </script>';	
					}
				} 
			else{
				$html = '<script> window.parent.alert("Se detecto 1 error consulte al Centro de Computos."); </script>';
				}

			return $html;
			}

		public function update(){
			$this		 ->init();
			$id 		 = $this->sanitizePostInt('id');
			$name 		 = $this->sanitizePostString('name');
			$description = $this->sanitizePostString('description');
			$keyword 	 = $this->sanitizePostString('keyword');
			$author 	 = $this->sanitizePostString('author');
			$editor 	 = $this->sanitizePostString('editor');
			$publish 	 = $this->sanitizePostDate('publish');
			$pages 		 = $this->sanitizePostInt('pages');
			$type 		 = null;
			$formato 	 = null;

			$sql = str_replace(
				array(':fil_name',':fil_description',':fil_keyword',':fil_author',':fil_editor',':fil_date_publish',':fil_pages',':fil_type',':fil_formato',':fil_id'),
				array($name,$description,$keyword,$author,$editor,$publish,$pages,$type,$formato,$id),
				$this->sqlDocFileUpdate
				);

			$query 	= $this->dbPDO->prepare($sql);
			$query	->execute();

			if($query->rowCount()){
				$html = '<script> window.parent.backend.form_grid(); </script>';	
				} 
			else{
				$html = '<script> window.parent.alert("Se detecto 5 errores consulte al Centro de Computos."); </script>';
				}

			return $html;
			}

		public function delete(){
			$this	->init();
			$fil_id = $this->sanitizeGetInt('id');

			$sql    = str_replace(':fil_id',$fil_id,$this->sqlDocFileOne);
			$query  = $this->dbPDO->prepare($sql);
			$query	->execute();
			$doc_file=$query->fetch(PDO::FETCH_OBJ);

			$sql    = str_replace(':fil_id',$fil_id,$this->sqlDocFileDelete);
			$query  = $this->dbPDO->prepare($sql);
			$html   = null;

			if($query->execute()){
				unlink($this->basePath.'/tmb/'.$doc_file->fil_image);
				unlink($this->basePath.'/pdfs/'.$doc_file->fil_file);
				$html  .= $this->html->h2('Archivos de Prensa','formTitle');
				$html  .= $this->msgSuccess('El archivo se ha eliminado en forma correcta.');
				$html  .= $this->baseGrid();
				}

			return $html;
			}

		public function status(){
			$this		->init();		
			$fil_id 	= $this->sanitizeGetInt('id');
			$fil_status = 'INACTIVO';
			$sql    	= str_replace(':fil_id',$fil_id,$this->sqlDocFileOne);
			$query  	= $this->dbPDO->query($sql);
			$doc_file 	= $query->fetch(PDO::FETCH_OBJ);
			if($doc_file->fil_status=='INACTIVO') $fil_status='ACTIVO';
			$sql    	= str_replace(array(':fil_id',':fil_status'),array($fil_id,$fil_status),$this->sqlDocFileStatus);

			$query  	= $this->dbPDO->prepare($sql);
			$html 		= null;
			if($query->execute()){
				$html  	= $this->html->h2('Archivos de Prensa','formTitle');
				$html  .= $this->msgSuccess('El estado se ha modificado en forma correcta.');
				$html  .= $this->baseGrid();
				} 
			
			return $html;
			}

		}

	class authenticate extends \docuprensa\backend\base {

		private $sqlDocUser = "select * from doc_user where usr_login=':login' and usr_pass=':password' and usr_status='ACTIVO';";

		public function form_login(){
			$this  ->init();
			$html  = $this->msgInfo('Utilice sus datos personales para ingresar al sistema.');
			$form  = $this->form();
			$form .= $this->html->br();
			$form .= $this->html->a('Ingresar','javascript: window.backend.loginSubmit();',null,'loginSubmit');
			$html .= $this->html->div($form,'loginForm');
			return $html;		
			}

		private function form($values=array()){
			$html  = null;
			$html .= $this->html->input('input','txtLogin',null,'maxlength:"10";required autofocus placeholder:"usuario";title:"Ingrese su nombre de usuario en forma correcta.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]+$"');
			$html .= $this->html->br();
			$html .= $this->html->input('password','txtPasswd',null,'maxlength:"10";required placeholder:"password";title:"Ingrese su password en forma correcta.";pattern:"^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]+$"');
			return $html;
			}

		public function login(){
			$this	  ->init();
			$login    = $this->sanitizePostString('login');
			$password = $this->sanitizePostString('password');

			$sql  	  = str_replace(
				array(':login',':password'),
				array($login,$password),
				$this->sqlDocUser
				);
			
			$query = $this->dbPDO->query($sql);
			$query ->execute();
			
			$doc_user = $query->fetch(PDO::FETCH_OBJ);
			if(isset($doc_user->usr_id)){
				$class  = new base;
				$html 	= $class->grid();
				$_SESSION['userLogin'] = true;
				} 
			else{
				$html  = $this->msgError('Los datos que envi&oacute; no son correctos.');
				$form  = $this->form();
				$form .= $this->html->br();
				$form .= $this->html->a('Ingresar','javascript: window.backend.loginSubmit();',null,'loginSubmit');
				$html .= $this->html->div($form,'loginForm');
				$_SESSION['userLogin'] = false;
				}

			return $html;
			}

		public function logout(){
			$_SESSION['userLogin'] = false;
			}

		}