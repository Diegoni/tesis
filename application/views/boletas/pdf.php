<?php
$pdf = new PDFF();
$inicio = 0;
$ipos	= 0;
$ybarra = 85;
$xbarra	= 45;
if($impresiones){
	foreach ($impresiones as $row) {
		$boleta = $row->impresion;
	}
}

if($boletas){
	foreach ($boletas as $row) {
		$pdf->AddPage();
		$pdf->SetFont('Arial','',11);
		
		$barra 		= $row->codigo_barra;
		$boleta_array = (array) $row;
		
		foreach ($impresiones_campos as $campos) {
			if($campos->formato == 'date'){
				$valor	= formatDate($boleta_array[$campos->campo]);
			} else if($campos->formato == 'importe'){
				$valor	= formatImporte($boleta_array[$campos->campo]);
			} else {
				$valor	= $boleta_array[$campos->campo];
			}						
			$boleta		= str_replace ($campos->cadena , $valor , $boleta );
		}
		
		$boleta		= str_replace ('&nbsp;' , ' ' , $boleta );
		$boleta		= str_replace ('&deg' , '°' , $boleta );
		$boleta		= str_replace ('Â' , '°' , $boleta );
		
		
		$pdf->WriteHTML($boleta);
				
		$code 		= new pdfbarcode128($barra, 36 ,100, "C");
		$code->set_pdf_document($pdf);
		$width		= $code->get_width();
		
		$code->draw_barcode($xbarra, $ybarra, 10, false );
		$pdf->SetFont("helvetica", "B", 9);
		$pdf->Text(60, $ybarra + 14 ,  $barra );
		$pdf->SetDrawColor(0, 0, 0);

	}
}
		
$pdf->Output();	