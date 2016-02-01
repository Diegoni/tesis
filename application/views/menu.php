<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AdminLTE 2 | Dashboard</title>
    <?php
    echo css_libreria('bootstrap/css/bootstrap.min.css');
	echo css_libreria('dist/css/AdminLTE.min.css');
	echo css_libreria('dist/css/skins/_all-skins.min.csS');
	echo css_libreria('plugins/iCheck/flat/blue.css');
	echo css_libreria('plugins/morris/morris.css');
	echo css_libreria('plugins/jvectormap/jquery-jvectormap-1.2.2.css');
	echo css_libreria('plugins/datepicker/datepicker3.css');
	echo css_libreria('plugins/daterangepicker/daterangepicker-bs3.css');
	echo css_libreria('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
	?>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<a href="index2.html" class="logo">
				<span class="logo-mini">Pagos</span>
				<span class="logo-lg">Pagos</span>
			</a>
			<nav class="navbar navbar-static-top" role="navigation">
	          	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	            	<span class="sr-only">Toggle navigation</span>
	          	</a>
				
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="hidden-xs">Alexander Pierce</span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="" class="img-circle" alt="User Image">
									<p>
										Alexander Pierce - Web Developer
										<small>Member since Nov. 2012</small>
									</p>
								</li>
		                  
								<li class="user-footer">
									<div class="pull-left">
										<a href="#" class="btn btn-default btn-flat">Profile</a>
									</div>
									<div class="pull-right">
										<a href="#" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
     
     
		<aside class="main-sidebar">
        	<section class="sidebar">
				<ul class="sidebar-menu">
					<li class="header">MAIN NAVIGATION</li>
		            <?php
		            $array = array(
						'General'	=> 'pages/UI/general.html',
						'Icons'		=> 'pages/UI/icons.html'
					);
					
					echo armar_menu('UI Elements', 'fa-laptop', $array);
		            
		            ?>
          		</ul>
        	</section>
		</aside>

		<div class="content-wrapper">
			<section class="content-header">
          		<h1>Titulo<small> Sub titulo</small></h1>
			</section>

			<section class="content">
          		<div class="row">
            		<section class="col-lg-7 connectedSortable">
						<div class="box box-info">
							<div class="box-header">
								<i class="fa fa-envelope"></i>
								<h3 class="box-title">Ventana</h3>

								<div class="pull-right box-tools">
									<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
								</div>
							</div>
							<div class="box-body">
								<form action="#" method="post">
									<div class="form-group">
										<input type="email" class="form-control" name="emailto" placeholder="Email to:">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="subject" placeholder="Subject">
									</div>
									<div>
										<textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
									</div>
								</form>
							</div>
                			<div class="box-footer clearfix">
                  				<button class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>
                			</div>
						</div>
					</section>
				</div>
			</section>
		</div>
      
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 1.0.0
			</div>
			<strong><a href="">XN Group</a>.</strong>
		</footer>

		<div class="control-sidebar-bg"></div>
	</div>
	
    <?php
     echo js_libreria('plugins/jQuery/jQuery-2.1.4.min.js');
	 echo js_libreria('plugins/jQueryUI/ui.js');
     echo js_libreria('bootstrap/js/bootstrap.min.js');
     //echo js_libreria('plugins/morris/morris.min.js'); ver kubreria 
	 echo js_libreria('plugins/sparkline/jquery.sparkline.min.js');
	 echo js_libreria('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');
	 echo js_libreria('plugins/jvectormap/jquery-jvectormap-world-mill-en.js');
	 echo js_libreria('plugins/knob/jquery.knob.js');
	 echo js_libreria('plugins/daterangepicker/daterangepicker.js');
	 echo js_libreria('plugins/datepicker/bootstrap-datepicker.js');
	 echo js_libreria('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
	 echo js_libreria('plugins/slimScroll/jquery.slimscroll.min.js');
	 echo js_libreria('plugins/fastclick/fastclick.min.js');
	 echo js_libreria('dist/js/app.min.js');
	 //echo js_libreria('dist/js/pages/dashboard.js');
	 echo js_libreria('dist/js/demo.js');
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

</html>
