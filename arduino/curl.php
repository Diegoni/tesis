<?php
date_default_timezone_set('America/Argentina/Mendoza');
if(isset($_GET['tarjeta']))
{
	$tarjeta = $_GET['tarjeta'];
	$sector = $_GET['sector'];
}else
{
	$tarjeta = 0;
	$sector = 0;
}

$ch = curl_init("http://localhost/tesis2/index.php/tambos_caminos/getCamino/".$tarjeta."/".$sector);


$file = fopen("logs/".date('Y-m-d')."_logs.txt", "a");
fwrite($file, "Lectura de tarjeta ".$tarjeta." sector ".$sector." hora ".date('H:i:s')." \n");
fclose($file);

curl_exec($ch);
curl_close($ch);
