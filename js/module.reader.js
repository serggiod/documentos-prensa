$(window.document).on('ready',function(){
	window.reader.init();
});
window.reader={
	init:function(){
		$.get('xhr/reader_filename.php',function(file){
			this.fileinit = file;
			html = '<iframe id="readerPDF" name="readerPDF" src="viewer.html?file='+'pdfs/'+this.fileinit+'" width="100%" height="100%">Se requiere un navegador moderno para utilizar correctamente esta aplicaci&oacute;n. Consulte en el Centro de Computos.</iframe>';
			$('#readerContent').html(html);
			});
		},
	fileinit:null
}