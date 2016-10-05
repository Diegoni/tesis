<?php
$html = setCss('plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css');
$html .= setJs('plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js');

/*--------------------------------------------------------------------------------  
            Carga de array necesarios
 --------------------------------------------------------------------------------*/ 
    
if($fields){
    foreach ($fields as $field) {
        $registro_values[$field] = '';
    }
}
        
if($registro){
    foreach ($registro as $row) {
        $registro_values = (array) $row;
    }
}

/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/ 

$html .= startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

if($registro){
    $html .= '<ul class="nav nav-tabs">';
    $html .= '<li class="active">';
    $html .= '<a  href="#1" data-toggle="tab">'.lang('datos').'</a>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<a href="#2" data-toggle="tab">'.lang('permisos').'</a>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '<br>';
}

/*--------------------------------------------------------------------------------  
            Formulario
 --------------------------------------------------------------------------------*/ 

$html .= '<div class="tab-content ">';
$html .= '<div class="tab-pane active" id="1">'; 
$html .= '<form action="#" method="post" class="form-horizontal">';
$html .= '<div class="form-group">';
$html .= '<label class="col-sm-2 control-label">'.lang('categoria').' '.lang('padre').'</label>';
$html .= '<div class="col-sm-8">';
$html .= '<select name="id_padre" id="id_padre" class="form-control" onchange="controlPadre(this.value)">';
$html .= '<option value="0"></option>';

if($menus)
{
    foreach ($menus as $row_menu) 
    {
        if($row_menu->id_menu == $registro_values['id_padre'])
        {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        
        $html .= '<option value="'.$row_menu->id_menu.'" '.$selected.'>'.$row_menu->menu.'</option>';    
    }    
}
$html .= '</select>';
$html .= '</div>';
$html .= '</div>';
$html .= setForm($campos, $registro_values, $registro, $id_table);
$html .= '</form>';
$html .= '</div>';

/*--------------------------------------------------------------------------------  
            Tabla con los roles
 --------------------------------------------------------------------------------*/ 

$html .= '<div class="tab-pane" id="2">'; 
$cabeceras = array(
    lang('rol'),
    lang('ver'),
    lang('editar'),
);

$html .= '<h4>'.lang('menu').' '.$registro_values['menu'].'</h4>';
$html .= startTable($cabeceras);

if($usuarios_permisos)
{
    foreach ($usuarios_permisos as $row) 
    {
        $ver    = getBootstrapSwitch($row->ver, $row->id_permiso, 'cambiarPermisoVer', $permiso_editar);
        $editar = getBootstrapSwitch($row->editar, $row->id_permiso, 'cambiarPermisoEditar', $permiso_editar);
        
        $registro = array
        (
            $row->id_perfil,
            $ver,
            $editar,
        );
        
        $html .= setTableContent($registro);  
    }
}

$html .= endTable();         

$html .= '</div>';
$html .= '</div>';

/*--------------------------------------------------------------------------------  
            Fin del contenido y js
 --------------------------------------------------------------------------------*/ 
 
$html .= endContent();

echo $html;
?>

<script>
$("[data-inputmask]").inputmask();
$(".checkbox").bootstrapSwitch();

function cambiarPermisoVer(id_rol_permiso)
{
     if($("[id='"+id_rol_permiso+"cambiarPermisoVer']").bootstrapSwitch('state')){
         valor = 1
     } else{
         valor = 0;
     }
     
     campo = 'ver';
     
     $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/<?php echo $subjet; ?>/cambiarPermiso/',
        data: { id_rol_permiso: id_rol_permiso, valor: valor, campo: campo},
        success: function(resp) { 

        }
    });
}



function cambiarPermisoEditar(id_rol_permiso)
{
     if($("[id='"+id_rol_permiso+"cambiarPermisoEditar']").bootstrapSwitch('state')){
         valor = 1
     } else{
         valor = 0;
     }
     
     campo = 'editar';
     
     $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/Permisos/cambiarPermiso/',
        data: { id_rol_permiso: id_rol_permiso, valor: valor, campo: campo},
        success: function(resp) { 
           
        }
    });
}


$(function() {
    controlPadre($('#id_padre').val());
});

function controlPadre(valor)
{
    if(valor != 0){
        $('#url').prop('disabled', false);
        $("#label_menu").html("Menu");
    }else{
        $('#url').prop('disabled', true);
        $("#label_menu").html("Categoria");
    }
}
</script>

<style>
    .bootstrap-switch{
        
    }
</style>
