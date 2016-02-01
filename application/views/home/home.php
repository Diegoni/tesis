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
							<input type="email" class="form-control" name="emailto" >
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="subject" >
						</div>
						<div>
							<textarea class="textarea" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
						</div>
					</form>
				</div>
      			<div class="box-footer clearfix">
      				<button class="pull-right btn btn-default" id="sendEmail">
      					<?php echo $this->lang->line('enviar'); ?> <i class="fa fa-arrow-circle-right"></i>
      				</button>
				</div>
			</div>
		</section>
	</div>
</section>