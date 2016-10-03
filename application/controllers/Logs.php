<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends My_Controller 
{
	protected $_subject		= 'logs';
	
	function __construct()
	{
        parent::__construct(
            $subject    = $this->_subject,
            $model      = '' 
        );
	} 
	
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Ver archivos de logs
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  


	function index()
	{
		$ruta = APPPATH."/logs/";
	    if (is_dir($ruta)){
	        if ($aux = opendir($ruta)){
	        	echo '<table>';
	        	echo '<tr><th>File</th><th>Size</th></tr>';
				$total_archivos = 0;
	            while (($archivo = readdir($aux)) !== false){
	                if ($archivo!="." && $archivo!=".."){
	                    $ruta_completa = $ruta . '/' . $archivo;
	                    if (is_dir($ruta_completa)){
	                        echo "<br /><strong>Directorio:</strong> " . $ruta_completa;
	                        archivos($ruta_completa . "/");
	                    } else {
	                    	if($archivo != 'index.html'){
	                    		$tamano_archivo = filesize($ruta.$archivo);
	                    		echo '<tr><td><a href="'.base_url().'index.php/logs/archivo/'.$archivo.'">'.$archivo . '</a></td><td>'.formatBites($tamano_archivo, 1).'</td/></tr>';
								$total_archivos = $total_archivos + $tamano_archivo;
	                    	}
	                    }
	                }
	            }
	            closedir($aux);
				echo '<tr><th>Total</th><th>'.formatBites($total_archivos, 1).'</th></tr>';
				echo '</table>';
	        }
	    } else {
	        echo $ruta;
	        echo "<br />No es ruta valida";
	    }
	}


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
        Ver contenido del archivo
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 


	function archivo($archivo = NULL)
	{
		echo '
		<script>
		var clave = prompt("Clave");
	    if (clave != "1978") {
	        window.location.href = "'.base_url().'index.php/login/logout";
	    }
		</script>';
		if($archivo == NULL){
			redirect('logs', 'refresh');
		} else {
			$ruta	= APPPATH."/logs/".$archivo;
			if(is_file($ruta)){
				$this->load->library('user_agent');
				$ip		= $this->input->ip_address();
				if ($this->agent->is_browser()){
					$agent = $this->agent->browser();
				}else if ($this->agent->is_robot()){
			    	$agent = $this->agent->robot();
				}else if ($this->agent->is_mobile()) {
			    	$agent = $this->agent->mobile();
				} else {
			    	$agent = 'Unidentified User Agent';
				}
				$platform	= $this->agent->platform();
				log_message('DEBUG', 'Acceso a LOG, IP:'.$ip.' NAV:'.$agent.' PLA:'.$platform);
				
				$myfile = fopen($ruta, "r") or die("Unable to open file!");
				$i = 0;
				while(!feof($myfile)){
					$cadena = fgets($myfile);
					if(substr($cadena, 0, 5) == 'ERROR'){
						echo '<p style="color: red;">'.$i.' - '.$cadena. "</p>";
					}else{
						echo $i.' - '.$cadena. "<br />";	
					}
					
					$i = $i + 1;
				}	
			}else{
				log_message('ERROR', 'Acceso a :'.$ruta.' INCORRECTO');
			}
		}
	}
}