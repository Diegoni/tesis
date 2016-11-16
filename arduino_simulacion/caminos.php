<?php
include_once('php/m_animales_rutinas.php');
include_once('php/m_tambos_caminos.php');
include_once('php/m_tambos_caminos_detalles.php');

// Cargamos los datos iniciales

$datos = array(
	'id_animal' => $_GET['id_animal'],
	'id_sector' => $_GET['id_sector'],
	'hora'		=> date('H:i:s'),
	'dia'		=> date('w'),
);

// Buscamos que sector le corresponde al animal

$m_rutinas = new m_animales_rutinas();
$id_sector = $m_rutinas->getSector($datos);

// Si el sector no es donde debe estar

if($id_sector)
{
	if($datos['id_sector'] != $id_sector)
	{
		$m_caminos = new m_tambos_caminos();
		$id_camino = $m_caminos->getCamino($datos['id_sector'], $id_sector);
		
		if($id_camino)
		{
			$m_camino_detalles = new m_tambos_caminos_detalles();
			$camino = $m_camino_detalles->getCamino($id_camino);
		}else
		{
			$error = "No existe camino desde el sector ".$datos['id_sector']." a ".$id_sector;
		}	
	}else
	{
		$error = "El animal debe permanecer en el sector";
	}
}else
{
	$error = "No hay un sector asignado para el animal en este horario";
}


if(isset($error))
{
	echo $error;
}


