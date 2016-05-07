<?php 
echo start_content();

if(isset($mensaje)){
	if($mensaje == 'update_ok'){
		echo setMensaje($mensaje);
	}else{
		if(strpos($mensaje, 'No ha seleccionado')){
			$tipo = 'ok';
		} else {
			$tipo = 'error';
		}
		
		echo setMensaje($mensaje, $tipo);
	}
}

$id_modal = 'help';

echo form_open_multipart($subjet.'/do_upload');
?>

<div class="row">
	<?php echo setlabel($this->lang->line('archivo'), 2) ?>
	<div class="col-md-8">					
		<div class="form-group">
			<input type="file" class="form-control" name="userfile" />
		</div>
	</div>
	<div class="col-md-2">
		<?php echo btn_modal($id_modal); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<?php echo button_upl(); ?>
	</div>
</div>

</form>

<?php
$mensaje = $this->lang->line('archivo_banco');

echo end_content();
echo get_modal($id_modal, $mensaje);
	
?>