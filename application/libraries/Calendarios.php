<?php 
class Calendarios {
	var $css;
	var $js;
	var $default_color = 'f56954';
	var $default_title = '-';

		
	function __construct(){
		$CI =& get_instance();
		$CI->load->helper('url');

		$this->css	= '<link href="'.base_url().'librerias/plantilla/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" />';
		$this->js	= '<script src="'.base_url().'librerias/plantilla/plugins/fullcalendar/moment.min.js"></script>';
		$this->js  .= '<script src="'.base_url().'librerias/plantilla/plugins/fullcalendar/fullcalendar.min.js"></script>';	
	}
	
/*--------------------------------------------------------------------------------	
 			Función para armar el script de calendarios
 --------------------------------------------------------------------------------*/		
	
	function script($id, $fechas){
		$script = $this->css;
		$script .= $this->js;
		$script .= '<script>';
		$script .= "$('#".$id."').fullCalendar({";
		$script .= "firstDay: 1,";
		$script .= "monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],";
		$script .= "monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],";
		$script .= "dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'],";
		$script .= "dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],";
		$script .= "buttonText:{
						prev:     ' ◄ ',
						next:     ' ► ',
						prevYear: ' &lt;&lt; ',
						nextYear: ' &gt;&gt; ',
						today:    'hoy',
						month:    'mes',
						week:     'semana',
						day:      'día'
					},";
		$script .= "header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,basicWeek,basicDay'
					},";
		$script .= "editable: false,";
		$script .= "events: [";
		if($fechas){
            foreach ($fechas as $key => $value) {
            	// Varios calendarios con diferentes colores
            	if(is_array($value)){
            		$ano = date('Y', strtotime($value['date']));
		            $mes = date('m', strtotime($value['date'])) - 1;
		            $dia = date('d', strtotime($value['date']));
		            
		            if(isset($value['color'])){
		            	$color = $value['color'];
		            }else{
		            	$color = $this->default_color;
		            }
		            
					if(isset($value['value'])){
						$title = $value['value'];
					}else if(isset($value['title'])){
						$title = $value['title'];
					}else{
						$title = $this->default_title;
					}
							
	            	$script .= '{';
					$script .= "title: '".$title."',";
					$script .= "start: new Date(".$ano.", ".$mes.", ".$dia."),";
					$script .= 'backgroundColor: "#'.$color.'",';  
					$script .= 'allDay: true,';
					$script .= 'borderColor: "#'.$color.'"';
	            	$script .= '},';	
            	// Un calendario, color rojo	
            	} else {
	            	$ano = date('Y', strtotime($value));
		            $mes = date('m', strtotime($value)) - 1;
		            $dia = date('d', strtotime($value));
							
	            	$script .= '{';
					$script .= "title: '".$key."',";
					$script .= "start: new Date(".$ano.", ".$mes.", ".$dia."),";
					$script .= 'backgroundColor: "#'.$this->default_color.'",';  
					$script .= 'allDay: true,';
					$script .= 'borderColor: "#'.$this->default_color.'"';
	            	$script .= '},';	
            	}
            }
		}
		
		$script = substr($script, 0, -1);
		$script .= "]";
		$script .= "});";
		$script .= "</script>";
         	
		return $script;
	}
}