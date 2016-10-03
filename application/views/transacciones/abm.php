<?php 
if($registros){
    foreach ($registros as $row) {
        $id_estado      = $row->id_estado;
        
        if($row->id_estado == 3){ // Conciliada
            $widget_header  = 'primary';
            $datos = array(
                lang('fecha')             => formatDateTime($row->date_upd),
                lang('usuario')           => $row->user_upd,
                lang('comentario')        => $row->comentario,
                lang('importe_operacion') => formatImporte($row->importe_operacion),
            );
        }else if($row->id_estado == 1){ // Pagada
            $widget_header = 'green';
            $datos = array(
            );
        }else if($row->id_estado == 2){ // Anulada
            $widget_header = 'red';
            $datos = array(
                lang('fecha')             => formatDateTime($row->date_upd),
                lang('usuario')           => $row->user_upd,
            );
        }      
        
        if($row->id_transaccion > 1){
            $anterior = $row->id_transaccion - 1;
        }else {
            $anterior = FALSE;
        }
        
        $siguiente = $row->id_transaccion + 1; 
    }
} else {
   $anterior        = FALSE;
   $siguiente       = FALSE;
   $datos           = FALSE;
   $id_estado       = 0;
   $widget_header   = 'default';
}
?>
<section class="content">
    <div class="row" style="text-align: right;">
        <form action="" method="post">
        <div class="col-md-8">     
            <div class="input-group">
                <input <?php echo completarTag('transaccion', '', '[99999-99999]'); ?>>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i> <?php echo lang('buscar')?></button></button>
                </span>
            </div>
        </div>
        </form>
                     
        
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-4" style="padding-right: 2px; ">       
                    <?php 
                    if($anterior){
                        echo '<a href="'.base_url().'index.php/Transacciones/abm/'.$anterior.'" class="btn btn-default form-control"><i class="fa fa-arrow-left"></i> '.lang('anterior').'</a> ';    
                    }        
                    ?>
                </div> 
                <div class="col-md-4" style="padding-right: 2px; padding-left: 2px;">               
                    <?php
                    echo '<a href="'.base_url().'index.php/Transacciones/table/" class="btn btn-default form-control"><i class="fa fa-table"></i> '.lang('tabla').'</a> ';
                    ?>
                </div> 
                <div class="col-md-4" style="padding-left: 2px; ">               
                    <?php
                    if($siguiente){
                        echo '<a href="'.base_url().'index.php/Transacciones/abm/'.$siguiente.'" class="btn btn-default form-control"><i class="fa fa-arrow-right"></i> '.lang('siguiente').'</a> ';
                    }                        
                    ?>        
                </div> 
            </div> 
        </div>           
           
    </div>
    <hr style=" margin-top: 3px; margin-bottom: 3px;">

    <div class="row">
        <div class="col-md-8">  
            <div class="box box-widget widget-user-2">
                <span class="info-box-icon" style="background: transparent;color: #fff;">
                    <i class="fa fa-exchange wow fadeInRight" aria-hidden="true"></i>
                </span>
                <div class="widget-user-header bg-<?php echo $widget_header?>">
                    <?php 
                    if($registros){
                        $barra_interna = substr($row->barra_interna, 0, 5).'-'.substr($row->barra_interna, 5);
                        echo '<h3 class="widget-user-username">'.$barra_interna.'</h3>';
                        echo '<h5 class="widget-user-desc">'.lang('transaccion').' '.$row->estado.'</h5>';
                    }else{
                        echo '<h3 class="widget-user-username">'.$transaccion.'</h3>';
                        echo '<h5 class="widget-user-desc">'.lang('transaccion').' '.lang('no_encontrada').'</h5>';
                    }
                    ?>
                </div>
                <div class="box-footer no-padding">
                    <?php 
                    if($id_estado == 1){
                        echo '<form action="'.base_url().'index.php/'.$subjet.'/conciliacion" class="text-center" method="post">';
                        echo '<input type="hidden" name="transaccion" value="'.$barra_interna.'">';
                        echo '<button type="submit" class="btn btn-app" style="margin-top: 15px; margin-bottom: 15px;">
                                <i class="fa fa-thumb-tack"></i> '.lang('conciliar').'
                                </button>';
                        echo '</form>';    
                    }else if($datos){
                        echo '<ul class="nav nav-stacked">';
                        foreach ($datos as $key => $value) {
                            echo '<li><a href="#">'.$key.'<span class="pull-right ">'.$value.'</span></a></li>';
                        }
                        echo '</ul>';
                    }                            
                    ?>
                </div>
            </div>
        </div>
            
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fa fa-money wow fadeInLeft" aria-hidden="true"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"><?php echo lang('importe')?></span>
                    <span class="info-box-number">
                        <?php if($registros){ ?>
                        <?php echo formatImporte($row->importe)?>
                        <?php } ?>
                    </span>
                </div>
            </div>
              
            <div class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fa fa-calendar wow fadeInRight"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"><?php echo lang('fecha').' '.lang('pago')?></span>
                    <span class="info-box-number">
                        <?php if($registros){ ?>
                        <?php echo formatDateTime($row->date_add)?>
                        <?php } ?>
                    </span>
                </div>
            </div>
              
        </div>
    </div>
<script>
    $("[data-inputmask]").inputmask();
</script>              