<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SRP</title>
    <?php
    echo css_libreria('bootstrap/css/bootstrap.css');
	echo css_libreria('dist/css/AdminLTE.min.css');
	echo css_libreria('dist/css/skins/_all-skins.min.css');
	echo css_libreria('plugins/jQueryUI/jquery-ui.css');
	echo css_libreria('main/css/main.css');
	echo css_libreria('plugins/chosen/chosen.css');

	echo js_libreria('plugins/jQuery/jQuery-2.1.4.min.js');
	echo js_libreria('plugins/jQueryUI/jquery-ui.js');
	echo js_libreria('bootstrap/js/bootstrap.min.js');

	echo js_libreria('dist/js/app.min.js');
	echo js_libreria('dist/js/demo.js');
	echo js_libreria('main/js/main.js');
	
	echo js_libreria('plugins/ckeditor/ckeditor.js');
	echo js_libreria('plugins/ckeditor/config.js');
	
	echo js_libreria('plugins/print/printThis.js');
	echo js_libreria('plugins/chosen/chosen.jquery.js');
	
	echo js_libreria('plugins/input-mask/jquery.inputmask.js');
	echo js_libreria('plugins/input-mask/jquery.inputmask.date.extensions.js');
	echo js_libreria('plugins/input-mask/jquery.inputmask.extensions.js');	
	?>

    <link href="<?php echo base_url()?>librerias/plantilla/plugins/font/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

</head>

<script>
<?php if(isset($config['importe_max'])){ ?> 
$(document).ready(function(){
    $(".importe").attr('maxlength','<?php echo $config['importe_max'] ?>');
    $("input:text").attr('maxlength','<?php echo $config['input_max'] ?>');
});
<?php } ?>
</script>