		</div>
		<footer class="main-footer" >
			<div class="pull-right hidden-xs">
			    <b><?php echo lang('carga')?></b>
			    <?php 
			    $tiempo_carga = $this->benchmark->elapsed_time('inicio', 'final');
			    echo $tiempo_carga;
                if($tiempo_carga > 2 ){
                    $log = 'CONTROLAR TIEMPO DE CARGA DE '.$this->benchmark->elapsed_time('inicio', 'final');
                    $log .= ' EN '.$this->uri->segment(1).'/'.$this->uri->segment(2).'/';
                    log_message('ERROR', $log);    
                }
                ?>
				<b><?php echo lang('version')?></b> 1.0.1
			</div>
			<strong>
			    <a href="">XN Group </a>
            </strong>
			
		</footer>

		<div class="control-sidebar-bg"></div>
	</div>
</html>

<!--------------------------------------------------------------------------------	
 			Ir arriba button
 -------------------------------------------------------------------------------->	

<a href="#" class="scrollup btn btn-default" title='<?php echo lang('ir_arriba') ?>'>
	<i class="fa fa-arrow-up"></i> 
</a>

<!--------------------------------------------------------------------------------  
            Function para buscar en base de datos por ajax
 -------------------------------------------------------------------------------->

<script>


function getUnique(campo, valor, base)
{
    if($("#agregar").length != 0) {
        accion = 'agregar';
    }else if($("#modificar").length != 0) {
        accion = 'modificar';
    }
    
     $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/<?php echo $subjet?>/getUnique/',
        data: { valor: valor, campo: campo, accion: accion, base: base},
        success: function(resp) {
            if(resp == 0){
                $('#'+campo).focus();
                $('#alert').removeClass('hide');
                $('#'+accion).prop('disabled', true);
                if(accion == 'agregar'){
                    $('#agregar_per').prop('disabled', true);
                }
                $('#mensaje_error').html('<p>'+campo.toUpperCase()+' = '+valor+', ya existe en base de datos</p>');
            }else{
                $('#mensaje_error').html('');
                $('#alert').addClass('hide');
            }
        }
    });
}
$( function() {
    $(".date").datepicker();
    $(".datetime").datetimepicker();
    $(".select2").select2();
    $(".time").timepicker();
    
    if ( $( "#comentario" ).length ) 
    {
        CKEDITOR.replace('comentario');
    }        
});
</script>