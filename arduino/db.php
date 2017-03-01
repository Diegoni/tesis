<?php
$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("test", $conexion);

if(isset($_GET['registro'])){
	$fecha = date('Y/m/d H:i:s');
	$registro = $_GET['registro'];

	$query = "INSERT INTO registros(registro, fecha) VALUES ('".$registro."', '".$fecha."')";

	mysql_query($query, $conexion);

	$id = mysql_insert_id();
	
	//echo $id;
	echo '090';
}

