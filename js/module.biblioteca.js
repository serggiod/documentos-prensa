$(window.document).on('ready',function(){
	window.biblioteca.init();
	});
window.biblioteca={
	init:function(){
		h=window.main.height -33;
		$.getJSON('xhr/biblioteca_grid.php',function(json){
			html  = '<div id="filtroDiv">';
			html += '<input id="filtroText" name="filtroText" type="text" value="" />';
			html += '	<a     id="filtroSubmit" href="javascript: window.biblioteca.submit()"><img src="img/search.png" height="11"/></a>';
			html += '	<a     id="filtroSubmit" href="javascript: window.biblioteca.reset()"><img src="img/reset.png" height="11"/></a>';
			html += '</div>';
			html += '<div id="bibliotecaGrid" style="height:'+h+'px;">';
			for(i in json){
				html += '	<div id="miniaturaDiv">';
				html += '		<a href="viewer.html?file='+'pdfs/'+json[i].file+'" target="readerPDF"><img id="miniaturaImg" src="'+'xhr/biblioteca_miniatura.php?file='+json[i].image+'"/></a>';
				html += '		<a id="miniaturaName" href="viewer.html?file='+'pdfs/'+json[i].file+'" target="readerPDF">'+json[i].name+'</a>';
				html += '	</div>';
			}
			
			html +='</div>';

			$('#bibliotecaContent').html(html);
			})
		},
	submit:function(){
		filtro = $('#filtroText').val();
		if(filtro){
			window.loader.show();
			$.getJSON('xhr/biblioteca_filtro.php?filtro='+filtro,function(json){
					html = null;
					if(json.length===0){
						html = '<div id="msgError">No se encontraron conincidencias.</div>';
						}
					else{
						html = '<div id="msgSuccess">Se encontraron '+json.length+' conincidencia/s.</div>';
						for(i in json){
							html += '	<div id="miniaturaDiv">';
							html += '		<a href="viewer.html?file='+'pdfs/'+json[i].file+'" target="readerPDF"><img id="miniaturaImg" src="'+'xhr/biblioteca_miniatura.php?file='+json[i].image+'"/></a>';
							html += '		<a id="miniaturaName" href="viewer.html?file='+'pdfs/'+json[i].file+'" target="readerPDF">'+json[i].name+'</a>';
							html += '	</div>';
							}
						} 
					$('#bibliotecaGrid').html(html);
					window.loader.hide();
				});
			}
		},
	reset:function(){
		window.loader.show();
		$.getJSON('xhr/biblioteca_reset.php',function(json){
			html = null;
			if(json.length===0){
				html = '<div id="msgError">No se encontraron conincidencias.</div>';
				}
			else{
				html = '<div id="msgInfo">Se ha reiniciado el filtro.</div>';
						for(i in json){
							html += '	<div id="miniaturaDiv">';
							html += '		<a href="viewer.html?file='+'pdfs/'+json[i].file+'" target="readerPDF"><img id="miniaturaImg" src="'+'xhr/biblioteca_miniatura.php?file='+json[i].image+'"/></a>';
							html += '		<a id="miniaturaName" href="viewer.html?file='+'pdfs/'+json[i].file+'" target="readerPDF">'+json[i].name+'</a>';
							html += '	</div>';
							}
				}
			$('#bibliotecaGrid').html(html);
			$('#filtroText').val('');
			window.loader.hide();
		});
		}
}