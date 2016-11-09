<?php

function getForm()
{
	return 
		'<form class="form-horizontal">
  			<div class="form-group">
    			<label for="animal" class="col-sm-2 control-label">Animal</label>
    				<div class="col-sm-10">
      					<input type="text" class="form-control" id="animal" placeholder="Código Animal" autocomplete="off" >
    				</div>
  			</div>
  
  			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-default">Enviar</button>
			    </div>
  			</div>
		</form>';

}		