<?php 
/*---------------------------------------------------------------------------------  
            Codigo para hacer pdf de la tabla
 --------------------------------------------------------------------------------*/  

$this->pdf->selectFont(APPPATH.'/third_party/ezpdf/fonts/Helvetica-Oblique.afm'); // Tipo de letra

$pdf_info = array (
    'Title'     => $title,
    'Author'    => $author
);
$this->pdf->addInfo($pdf_info);	
$i = 0;

foreach ($content as $results) {
	foreach ($results as $key => $value) {
		$contenido[$i][$key] = utf8_decode($value);
	}
	
	$i = $i + 1;
}

$options = array(
	'shadeCol'=>array(0.8,0.8,0.8),             			     		  
	'width'=>400   //Ancho de la Tabla.
);
$this->pdf->ezText($title."\n",10,array('justification'=>'center'));	
$this->pdf->ezTable($contenido);
$this->pdf->ezStream();