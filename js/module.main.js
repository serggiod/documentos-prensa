$(window.document).on('ready',function(){
	height = window.innerHeight -38;
	html  = '<div id="content" style="height:'+height+'px;">';
	html += '<div id="bibliotecaContent" style="height:'+height+'px;"></div>';
	html += '<div id="readerContent" style="height:'+height+'px;"></div>';
	html += '</div> ';
	window.main.height = height;
	$('body').append(html);
	$.ajaxSetup({cache:false});
	});

window.main={
	url:'',
	height:null	
	}

window.loader={
	show:function(){
		html  = '<div id="loader">';
		html += '<div id="loaderdisplay">';
		html += '<img src="img/loader.gif"><br>Espere un momento...';	
		html += '</div>';
		html += '</div>';
		$('body').append(html);
		},
	hide:function(){
		$('#loader').remove();
		}
	}