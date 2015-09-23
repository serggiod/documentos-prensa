$(window.document).jkey('ctrl+l',function(){
	window.loader.show();
	$.get('xhr/backend_form_login.php',function(html){
		window.backend.init(html);
		});
	});

$(window.document).jkey('ctrl+e',function(){
	url = 'xhr/backend_logout.php';
	$.get(url,function(){
		window.document.location.reload();	
		});
	});
window.backend={
	id:0,
	init:function(html){
		$('#content').css('overflow','auto');
		$('#content').html(html);
		window.loader.hide();	
		},
	loginE:0,
	loginSubmit:function(){
		this.loginSubmitSanitize();
		this.loginSubmitValidate();
		login = $('#txtLogin').val();
		passw =  CryptoJS.MD5($('#txtPasswd').val());
		url   = 'xhr/backend_login.php';
		prm   = 'login='+login+'&password='+passw;
		if(this.loginE==0){
			window.loader.show();
				$.post(url,prm,function(html){
					$('#content').html(html);
					window.loader.hide();
				});
			}
		else{
			alert('Existe un error en los campos.');
			this.loginE=0;
			}
		},
	loginSubmitSanitize:function(){
		login = $('#txtLogin').val();
		passw = $('#txtPasswd').val();
		for(i in window.formulario.L){
			regexp = new RegExp(window.formulario.L[i],'igm');
			login = login.replace(regexp,'');
			passw = passw.replace(regexp,'');
			}
		$('#txtLogin').val(login);
		$('#txtPasswd').val(passw);
		},
	loginSubmitValidate:function(){
		login = $('#txtLogin').val();
		passw = $('#txtPasswd').val();
		regexp  = new RegExp('^[0-9a-zA-Z]+$','igm');
		if(!login.match(regexp)){this.loginE++;}
		if(!passw.match(regexp)){this.loginE++;}
		},
	form_grid:function(){
			this.id=0;
			url = 'xhr/backend_grid.php';
			$.get(url,function(html){
				$('#content').html(html);
			});
		},
	form_nuevo:function(){
			url = 'xhr/backend_form_nuevo.php';
			$.get(url,function(html){
				window.formulario.E = 0;
				$('#content').html(html);
			});
		},
	form_visualizar:function(){ 
			if(this.id>=1){
				url = 'xhr/backend_form_visualizar.php?id='+this.id;
				$.get(url,function(html){
					window.formulario.E = 0;
					$('#content').html(html);
				});
			} else {
				alert('Primero tienes que elegir un archivo.');
			}
		},
	form_modificar:function(){
			if(this.id>=1){
				if(confirm('¿Esta seguro que desea modificar este archivo?')){
					url = 'xhr/backend_form_modificar.php?id='+this.id;
					$.get(url,function(html){
						window.formulario.E = 0;
						$('#content').html(html);
					});
				}
			} else {
				alert('Primero tienes que elegir un archivo.');
			}
		},
	form_eliminar:function(){ 
			if(this.id>=1){
				if(confirm('¿Esta seguro que desea eliminar este archivo?')){
					url = 'xhr/backend_delete.php?id='+this.id;
					$.get(url,function(html){
						$('#content').html(html);
					});
				}
			} else {
				alert('Primero tienes que elegir un archivo.');
			}
		},
	form_estado:function(){ 
			if(this.id>=1){
				if(confirm('¿Esta seguro que desea cambiar el estado de este archivo?')){
					url = 'xhr/backend_estado.php?id='+this.id;
					$.get(url,function(html){
						$('#content').html(html);
					});
				}
			} else {
				alert('Primero tienes que elegir un archivo.');
			}
		},
	paginar:function(n=0){
			url = 'xhr/archivo_paginar.php?p='+n;
			$.get(url,function(html){
				$('#formPager').remove();
				$('#formGrid').remove();
				$('#content').append(html);
			});
		},
	logout:function(){
		url = 'xhr/backend_logout.php';
		$.get(url,function(){
			window.document.location.reload();	
		});
		},
	button_submit:function(){
		window.formulario.sanitize();
		window.formulario.validate();
		window.formulario.validateFile('file','^.*\.(pdf|PDF)$');
		if(window.formulario.E==0){
			$('#formulario').submit(); 
			} 
		else{
			window.formulario.E=0;
			}
		},
	button_cancel:function(){ this.form_grid(); }
}

window.formulario={
	E:0,
	L:['%','#','&','>','<','¡','=',';',"'",'http://','href','src','url','select','insert','update','where','join','javascript','script','vbscript','expression','<applet','<meta','<xml','<blink','<link','<style','<script','<embed','<object','<iframe','<frame','<frameset','<ilayer','<layer','<bgsound','<title','<base','onabort','onactivate','onafterprint','onafterupdate','onbeforeactivate','onbeforecopy','onbeforecut','onbeforedeactivate','onbeforeeditfocus','onbeforepaste','onbeforeprint','onbeforeunload','onbeforeupdate','onblur','onbounce','oncellchange','onchange','onclick','oncontextmenu','oncontrolselect','oncopy','oncut','ondataavailable','ondatasetchanged','ondatasetcomplete','ondblclick','ondeactivate','ondrag','ondragend','ondragenter','ondragleave','ondragover','ondragstart','ondrop','onerror','onerrorupdate','onfilterchange','onfinish','onfocus','onfocusin','onfocusout','onhelp','onkeydown','onkeypress','onkeyup','onlayoutcomplete','onload','onlosecapture','onmousedown','onmouseenter','onmouseleave','onmousemove','onmouseout','onmouseover','onmouseup','onmousewheel','onmove','onmoveend','onmovestart','onpaste','onpropertychange','onreadystatechange','onreset','onresize','onresizeend','onresizestart','onrowenter','onrowexit','onrowsdelete','onrowsinserted','onscroll','onselect','onselectionchange','onselectstart','onstart','onstop','onsubmit','onunload'],
	F:['name','description','keyword','author','editor','publish','pages'],
	V:['string','string','string','string','string','date','int'],
	sanitize:function(){
		for(f in this.F){
			obj = $('#'+this.F[f]);
			text = obj.val();
			for(l in this.L){
				regexp = new RegExp(this.L[l],'igm');
				text = text.replace(regexp,'');
				}
			obj.val(text);
			}
		},
	validate:function(){
		for(f in this.F){
			switch(this.V[f]){
				case 'int':
					regE = '^\\d+$';
					this.valid(this.F[f],regE);
				break;

				case 'string':
					regE = '^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\ \s\,\.]+$';
					this.valid(this.F[f],regE);
				break;

				case 'date':
					regE = '^(0[1-9]|1[0-9]|2[0-9]|3[0-1])-(0[1-9]|1[0-2])-(19[7-9][0-9]|20[0-2][0-9])$';
					this.valid(this.F[f],regE);
				break;

				case 'file':
					regE = '^.*\.(pdf|PDF)$';
					this.valid(this.F[f],regE);
				break;
				}
			}
		},
	validateFile:function(field,regE){
		if($('#'+field).length){
			element = $('#'+field);
			regexp  = new RegExp(regE,'igm');
			text    = element.val();
			if(text.match(regexp)){
				element.css('background-color','#DFF2BF');
				}
			else{
				element.css('background-color','#FFCECE');
				this.E++;
				}
			}
		},
	valid:function(field,regE){
		element = $('#'+field);
		regexp  = new RegExp(regE,'igm');
		text    = element.val();
		if(text.match(regexp)){
			element.css('background-color','#DFF2BF');
			}
		else{
			element.css('background-color','#FFCECE');
			element.val(null);
			this.E++;
			}
		}
}