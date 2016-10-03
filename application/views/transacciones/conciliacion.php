<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$html = startContent();

/*--------------------------------------------------------------------------------  
            Formulario
 --------------------------------------------------------------------------------*/ 
 
if($transaccion){
    $tags = 'disabled';
    $button = 'disabled';
    $complete_value = $ingreso;
} else {
    $tags = 'autofocus required';
    $button = '';
    $complete_value = '';
}    
 
$html .= '<form action="'.base_url().'index.php/'.$subjet.'/conciliacion/" method="post" class="form-horizontal">';
$html .= '<div class="form-group">';
$html .= setLabel(lang('transaccion'), 2);
$html .= '<div class="col-sm-6">';
if(!$transaccion){
    $html .= '<div class="input-group">';   
}

$html .= '<input '.completarTag('transaccion', $complete_value, '[99999-99999]', 'input-lg').' '.$tags.' >';

if(!$transaccion){
    $html .= '<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>';
    $html .= '</div>';
}    
$html .= '</div>';
$html .= '<div class="col-sm-4">';
$html .= '<button type="submit" class="btn btn-default form-control input-lg" id="enviar" '.$button.' >'.lang('buscar').'</>';
$html .= '</div>';
$html .= '</div>';
$html .= '</form>';

/*--------------------------------------------------------------------------------  
            Conciliacion
 --------------------------------------------------------------------------------*/ 

if($transaccion){
    $html .= '<form action="'.base_url().'index.php/'.$subjet.'/conciliacion/" method="post" class="form-horizontal">';
    
    $html .= '<hr>';
    $html .= '<div class="col-sm-12">';
    $html .= '<a href="'.base_url().'index.php/transacciones/conciliacion/" class="btn btn-danger pull-right" title="cancelar">X</a>';
    $html .= '<h3 class="profile-username text-center">'.lang('conciliar').' '.lang('transaccion').'</h3>';
    $html .= '<p class="text-muted text-center">'.lang('datos').'</p>';
    $html .= '</div>';
    
    $items = array(
        lang('transaccion')     => substr($transaccion['barra_interna'], 0, 5).'-'.substr($transaccion['barra_interna'], 5),
        lang('importe')         => formatImporte($transaccion['importe']),
        lang('fecha')           => formatDate($transaccion['date_add']),
        lang('id')              => $transaccion['transaccion'],
    );
    
    $html .= '<div class="col-sm-5">';
    $html .= '<div class="box-body box-profile">';
    $html .= '<ul class="list-group list-group-unbordered">';
    foreach ($items as $key => $value) {
        $html .= '<li class="list-group-item">';
        $html .= '<b>'.$key.'</b> <a class="pull-right">'.$value.'</a>';
        $html .= '</li>';        
    }
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</div>';
      
    $html .= '<div class="col-sm-7">';
    $html .= '<div class="box-body box-profile">';
    $html .= '<div class="form-group">
                '.setLabel(lang('comentario'), 2).'
                <div class="col-sm-10"> 
                    <textarea '.completarTag('comentario', '', 'onlyCharInt').'  rows="5" required autofocus></textarea>
                </div>
              </div> ';
    $html .= '<div class="form-group">
                '.setLabel(lang('importe'), 2).' 
                <div class="col-sm-10"> 
                    <input '.completarTag('importe_operacion', '', 'onlyFloat').' required>
                </div>
             </div>';
    $html .= '</div>'; 
    $html .= '</div>';
    
    $html .= '<div class="col-sm-6 col-md-offset-3">';
    $html .= '<input type="hidden" name="id_transaccion" value="'.$transaccion['id_transaccion'].'">';                  
    $html .= '<button type="submit" href="#" class="btn btn-primary btn-block input-lg"><b>'.lang('conciliar').'</b></button>';
    $html .= '</div>';
    
    $html .= '</form>';
}   

/*--------------------------------------------------------------------------------  
            Mensaje
 --------------------------------------------------------------------------------*/ 

if(isset($mensaje)){
    $html .= setMensaje($mensaje, $tipo_mensaje);
}
 
 /*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;

?>

<script>
    $("[data-inputmask]").inputmask();
</script>