<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
require_once APPPATH."/libraries/codigos/Codigos.php";

class Pago_boletas extends Codigos {
	protected $_formato = array(
		'nro_ente'			=> array('start' => 0,	'size' => 4, 	'control' => 'int',		'value' => '6100'),
		'convenios'			=> array('start' => 4,	'size' => 1, 	'control' => 'int'),
		'cod_ente'			=> array('start' => 5,	'size' => 4, 	'control' => 'int'),
		'cod_afiliado'		=> array('start' => 9,	'size' => 11, 	'control' => 'int'),
		'cuota'				=> array('start' => 20,	'size' => 3, 	'control' => 'int'),
		'fecha_venc_1'		=> array('start' => 23,	'size' => 5, 	'control' => 'dateJ'),
		'importe_venc_1'	=> array('start' => 28,	'size' => 6, 	'control' => 'float'),
		'fecha_venc_2'		=> array('start' => 34,	'size' => 5, 	'control' => 'dateJ'),
		'importe_venc_2'	=> array('start' => 39,	'size' => 6, 	'control' => 'float'),
		'tipo_cuota'		=> array('start' => 45,	'size' => 2, 	'control' => 'int'),
		'digito_ver'		=> array('start' => 47,	'size' => 1, 	'control' => 'int'),
		'agencia'			=> array('start' => 48,	'size' => 4, 	'control' => 'int'),
		'terminal'			=> array('start' => 52,	'size' => 4, 	'control' => 'int'),
		'nro_transaccion'	=> array('start' => 56,	'size' => 10, 	'control' => 'int'),
		'fechapago'			=> array('start' => 66,	'size' => 8, 	'control' => 'date'),
		'importe'			=> array('start' => 74,	'size' => 8,	'control' => 'float'),
		'codigo_barra'		=> array('start' => 0,	'size' => 48,	'control' => 'int'),
		'codigo_pago'		=> array('start' => 0,	'size' => 82,	'control' => 'int'),
	);
	
	protected $_size_linea = 82;
	
    function __construct() {
    	parent::__construct(
			$formato		= $this->_formato,
			$size_linea		= $this->_size_linea
		);
    }
}