<?php 
$html = '';
	
foreach($css_files as $file){
	$html .= '<link type="text/css" rel="stylesheet" href="'.$file.'" />';
} 

foreach($js_files as $file){
	if(!strpos($file, 'jquery-1.10.2.min.js')){
		$html .= '<script src="'.$file.'"></script>';
	}
}

$html .= start_content();
$html .= $output; 
$html .= end_content();

echo $html;
?>