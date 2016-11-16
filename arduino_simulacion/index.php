<?php
include_once('php/svg.php');
include_once('php/search.php');
include_once('php/form.php');
include_once('php/m_tambos_sectores.php');

$m_tambos = new m_tambos_sectores();
$tambos = $m_tambos->get_registros();

?>

<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Interactive 3D Mall Map | Codrops</title>

		<!--<link rel="shortcut icon" href="favicon.ico">-->
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link href="../librerias/plantilla/plugins/font/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="../librerias/plantilla/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

		<script src="js/modernizr-custom.js"></script>
	</head>
	<body>
		
	<?php echo getSvg();?>
		
	<div class="container">
		
			<div class="main">
				<header class="codrops-header">
					<h1>Simulación del sistema de tambos </h1>
				</header>
				<div class="mall">
					<div class="surroundings">
						<img class="surroundings__map" src="img/surroundings.svg" alt="Surroundings"/>
					</div>
					<div class="levels">
						<div class="level level--1" aria-label="Level 1">
							<svg class="map map--1" viewBox="0 0 1200 800" width="100%" height="100%" preserveAspectRatio="xMidYMid meet">
								<title>Map Level 1</title>
								<polygon points="1035.94 787.41 1035.94 423.16 855.37 423.16 855.37 350.52 1187.28 350.52 1187.28 12.59 548.09 12.59 548.09 68.87 437.36 68.87 437.36 12.59 49.37 12.59 49.37 366.5 12.72 366.5 12.72 787.41 356.2 787.41 414.93 584.41 554.4 584.41 627.81 787.41 1035.94 787.41" class="map__ground" />
								<path d="M1187.28,12.59V350.52H855.37v72.64h180.58V787.41H627.81l-73.41-203H414.93l-58.73,203H12.72V366.5H49.37V12.59h388V68.87H548.08V12.59h639.19M1200,0H535.36V56.28H450.09V0H36.65V353.91H0V800H365.8l2.64-9.13L424.52,597H545.44l70.39,194.65,3,8.35h429.82V410.57H868.09V363.11H1200V0h0Z" class="map__outline" />
								
								<!-- Lago y puntos verdes -->
								<path d="M475.68,198.63c-6.85-14.83-46.38-30.35-58-11.24-41.24,67.9-83.63,118.16-65.12,124.22,7.55,2.48,56.77.11,94.11-54.39,21.35-31.13,31.71-52.74,29-58.59h0Z" class="map__lake" />
								<ellipse cx="439.64" cy="214.94" rx="13.95" ry="13.8" class="map__tree" />
								<ellipse cx="419.54" cy="191.71" rx="13.95" ry="13.8" class="map__tree" />
								<ellipse cx="404.59" cy="220.27" rx="13.95" ry="13.8" class="map__tree" />
								<rect x="300.88" y="220.62" width="30" height="30" class="map__space" />
								
								
								<!-- Lago 2 y puntos verdes -->
								<path d="M724.87,696.45c14.61,7.58,42.34-6.42,52.85-26.15,24.57-46.13-43.25-126.94-61.66-120.57-7.5,2.6-6.47,29.34-4.4,82.81C713.74,686.25,719.12,693.46,724.87,696.45Z" class="map__lake" />
								<ellipse cx="738.82" cy="595.48" rx="13.95" ry="13.8" class="map__tree" />
								<ellipse cx="768.46" cy="605.4" rx="13.95" ry="13.8" class="map__tree" />
								<ellipse cx="744.64" cy="624.92" rx="13.95" ry="13.8" class="map__tree" />
								
								<!-- Circulos de abajo -->
								<polygon points="768.46 722.99 789.65 735.1 789.65 759.31 768.46 771.42 747.27 759.31 747.27 735.1 768.46 722.99" class="map__space" />
								<rect x="666.88" y="565.62" width="26.26" height="25.99" class="map__space" />
								
								<!-- Cuadrado gris de arriba centro -->
								<path d="M492.72,123.19c30.57,0,55.36-24.53,55.36-54.78H437.36C437.36,98.67,462.15,123.19,492.72,123.19Z" class="map__space" />
							
								<!-- Estacionamiento -->
								<rect x="48.08" y="501.73" width="35.61" height="35.23" class="map__space" />
								<rect x="94.01" y="501.73" width="35.61" height="35.23" class="map__space" />
								<rect x="139.5" y="501.73" width="35.61" height="35.23" class="map__space" />
								<rect x="48.3" y="547.25" width="35.61" height="35.23" class="map__space" />
								<rect x="94.24" y="547.25" width="35.61" height="35.23" class="map__space" />
								<rect x="139.72" y="547.25" width="35.61" height="35.23" class="map__space" />
								
									
								<polygon points="218.01 585.07 239.2 597.17 239.2 621.38 218.01 633.49 196.82 621.38 196.82 597.17 218.01 585.07" class="map__space" />
								<polygon points="410.01 601.42 358.8 778.44 320.06 767.07 372.92 591.6 410.01 601.42" class="map__space" />
								<polygon points="561.3,603.9 624,777 661.9,763.2 597.7,591.5" class="map__space" />
							
								
									
								<?php
								foreach ($tambos as $tambo) 
								{
									if($tambo['points'] != '')
									{
										echo '<polygon data-space="1.0'.$tambo['id_sector'].'" points="'.$tambo['points'].'" class="map__space" />';
									}else
									{
										echo '<rect data-space="1.0'.$tambo['id_sector'].'" x="'.$tambo['x'].'" y="'.$tambo['y'].'" width="'.$tambo['width'].'" height="'.$tambo['height'].'" class="map__space" />';
									}
								}
								?>
								
							</svg>
							<div class="level__pins">
								<?php
								foreach ($tambos as $tambo) 
								{
									echo '
									<a class="pin pin--1-'.$tambo['id_sector'].'" data-category="'.$tambo['id_tipo'].'" data-space="1.0'.$tambo['id_sector'].'" href="#">
										<span class="pin__icon">
											<svg class="icon icon--pin"><use xlink:href="#icon-pin"></use></svg>
											<svg class="icon icon--logo"><use xlink:href="#"></use></svg>
										</span>
									</a>';
								}
								?>
							</div>
							<!-- /level__pins -->
						</div>
					</div>
					<!-- /levels -->
				</div>
				<!-- /mall -->
				<button class="boxbutton boxbutton--dark open-search" aria-label="Show search"><svg class="icon icon--search"><use xlink:href="#icon-search"></use></svg></button>
				<nav class="mallnav mallnav--hidden">
					<button class="boxbutton mallnav__button--up" aria-label="Go up"><svg class="icon icon--angle-down"><use xlink:href="#icon-angle-up"></use></svg></button>
					<button class="boxbutton boxbutton--dark mallnav__button--all-levels" aria-label="Back to all levels"><svg class="icon icon--stack"><use xlink:href="#icon-stack"></use></svg></button>
					<button class="boxbutton mallnav__button--down" aria-label="Go down"><svg class="icon icon--angle-down"><use xlink:href="#icon-angle-down"></use></svg></button>
				</nav>
				<div class="content">
					<?php
					foreach ($tambos as $tambo) 
					{
						echo '
						<div class="content__item" data-space="1.0'.$tambo['id_sector'].'" data-category="'.$tambo['id_tipo'].'">
							<h3 class="content__item-title">'.$tambo['sector'].'</h3>
							<div class="content__item-details">
								<p class="content__meta">
									'.$tambo['comentario'].'
								</p>
								<p class="content__desc">
									';
									if($tambo['id_tipo'] != 4)
									{
										echo getForm($tambo['id_sector']);
									}
								echo '
								</p>
							</div>
						</div>';
					}
					?>
					
					
					<button class="boxbutton boxbutton--dark content__button content__button--hidden" aria-label="Close details"><svg class="icon icon--cross"><use xlink:href="#icon-cross"></use></svg></button>
				</div>
				<!-- content -->
			</div>
			<!-- /main -->
			<?php echo getSearch() ?>
			<!-- /spaces-list -->
		</div>
		<!-- /container -->
		<script src="js/classie.js"></script>
		<script src="js/list.min.js"></script>
		<script src="js/main.js"></script>
	</body>
	
<script>
	openContent('1.01');
</script>