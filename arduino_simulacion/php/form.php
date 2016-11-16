<?php

function getForm($id_sector)
{
	return 
		'<form class="form-horizontal" method="get" action="caminos.php">
  			<div class="form-group">
    			<label for="animal" class="col-sm-2 control-label">Animal</label>
    			<div class="col-sm-10">
      				<input type="text" class="form-control" id="id_animal" name="id_animal" placeholder="Código Animal" autocomplete="off" required>
    			</div>
  			</div>
  			
			<input type="hidden" id="id_sector" name="id_sector" value="'.$id_sector.'">
  
  			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-default">Enviar</button>
			    </div>
  			</div>
		</form>';

}		