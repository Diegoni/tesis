<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

class Codigos {
	protected $par			= 3;
	protected $impar		= 1;
	protected $division		= 10;
	protected $decimales	= 2;
	protected $sim_decim	= '.';
	
	function __construct($formato, $size_linea) {
    	$this->_formato		= $formato;
		$this->_size_linea	= $size_linea;
    }
	
/*--------------------------------------------------------------------------------	
 			Función par separar los datos del codigo
 --------------------------------------------------------------------------------*/	

	function parcear_linea($linea){
		if(strlen($linea) > $this->_size_linea){
			foreach ($this->_formato as $campo => $valores) {
				$linea_return[$campo] = substr($linea, $valores['start'], $valores['size']);
			}
	
			return $linea_return;
		} else {
			return FALSE;
		}
	}

/*--------------------------------------------------------------------------------	
 			Arma el codigo 
 --------------------------------------------------------------------------------*/	 
	
	function armar_codigo($array_datos){
			
		foreach ($this->_formato as $key => $valores) {
			if($key != 'digito_ver'){
				if(isset($valores['value'])){
					$codigo_array[$key] = substr($valores['value'], 0, $valores['size']);
				} else {
					//$codigo_array[$key] = substr($array_datos[$key], 0, $valores['size']);	
					$codigo_array[$key] = $array_datos[$key];
				}
			}
		}
		
		$bandera		= TRUE;
		$codigo_return	= '';
		foreach ($codigo_array as $key => $value) {
			$arreglo = array(
				'value'		=> $codigo_array[$key],
				'size'		=> $this->_formato[$key]['size'],
				'control'	=> $this->_formato[$key]['control'],
			);
			
			$codigo_control = $this->controlDatos($arreglo);
			
			if($codigo_control){
				$codigo_return .= $codigo_control;
			}else{
				$bandera = FALSE;
			}
		}
		if($bandera){
			$codigo_return = $this->digito_verificador($codigo_return);
			return $codigo_return;	
		}else{
			return FALSE;
		}
	}
	
/*--------------------------------------------------------------------------------	
 			Control de datos, por tipo y tamaño
 --------------------------------------------------------------------------------*/	

	function controlDatos($datos){
		// control de fecha
		if($datos['control'] == 'dateJ'){
			$year	= date('y', strtotime($datos['value']));
			$day	= date('z', strtotime($datos['value']));
			$day	= $day + 1; //porque comienza de 0
			
			if(strlen($day) < 3){
				$resto = 3 - strlen($day);
				
				for ($i = 0 ; $i < $resto; $i++) { 
					$day = '0'.$day;
				}
			}
			$datos['value'] = $year.$day; 
		}
		
		// control de importe
		if($datos['control'] == 'float'){
			$dato = explode('.', $datos['value']);
			
			if(count($dato) == 1){
				$datos['value'] = $datos['value'].'00';
			}else{
				if(strlen($dato[1]) == 1){
					$datos['value'] = $dato[0].$dato[1].'0';
				}else if(strlen($dato[1]) == 2){
					$datos['value'] = $dato[0].$dato[1];
				}else{
					$digito_corte = substr($dato[1], 1, 1);
					$ultimo_digito = substr($dato[1], 2, 1);
					$dato[1] = substr($dato[1], 0, 2);
					
					if($digito_corte > 5){
						$dato[1] = $dato[1] + 1;
						if($dato[1] == 100){
							$dato[0] = $dato[0] + 1;
							$dato[1] = '00';
						}
					}
					
					$datos['value'] = $dato[0].$dato[1];
				}
			}
		}
		
		
		if($datos['control'] == ''){
			$char_completar = ' ';
		}else{
			$char_completar = '0';
		}
		// control de tamaño
		if(strlen($datos['value']) > $datos['size']){
			$datos['value'] = substr($datos['value'], 0, $datos['size']);
		}else if(strlen($datos['value']) < $datos['size']){
			$completar = $datos['size'] - strlen($datos['value']);
			
			for ($i = 0; $i < $completar; $i++) { 
				$datos['value'] = $char_completar.$datos['value'];
			}
		}
		
		return $datos['value'];
	}
	
/*--------------------------------------------------------------------------------	
 			Calculo del digito verificador
 --------------------------------------------------------------------------------*/	

	function digito_verificador($codigo){
		$cantidad	= strlen($codigo);
		
		$suma_producto = 0;
		for ($i = 0; $i < $cantidad; $i++) {
			$elemento = $codigo[$i];
			
			if ($i%2==0){
			    $multipo = $this->par;
			}else{
			    $multipo = $this->impar;
			} 
			
			$suma_producto = $suma_producto + $elemento * $multipo;
		}
		
		$resto = $suma_producto % $this->division;
		
		if($resto == 0){
			$dv = 0;
		}else{
			$dv = $this->division - $resto;
		}
		
		$elemento_2 = '';
		
		for ($i = 0; $i < $cantidad; $i++) {
			$elemento_2 .= $codigo[$i].',';
		}
		
		$codigo = $codigo.$dv;
		
		return $codigo;	
	}
}