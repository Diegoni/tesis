<?php 
$column_width = (int)(80/count($columns));
if(!empty($list)){
	echo '<table class="table table-hover table-condensed" id="flex1">';
	echo '<thead>';
	echo '<tr class="success">';
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Cabecera de la tabla
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/
	
	foreach($columns as $column){
		echo "<th width='".$column_width."%'>";
		if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){
			$class = $order_by[1];
		}else{
			$class = '';
		}
		echo '<div class="text-left field-sorting '.$class.'" rel="'.$column->field_name.'">';
		echo $column->display_as;
		echo '</div>';
		echo '</th>';
	}
	
	if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){
		echo '<th align="left" abbr="tools" axis="col1" class="">';
		echo '<div class="text-right">';
		echo $this->l('list_actions');
		echo '</div>';
		echo '</th>';
	}
		
	echo '</tr>';
	echo '</thead>';	
	echo '<tbody>';
	
/*-------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Cuerpo de la tabla
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/

	foreach($list as $num_row => $row){       
		echo '<tr>';
		foreach($columns as $column){
			if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){
				$class = 'sorted';
			}else{
				 $class = '';
			};
			echo "<td width='".$column_width."%' class='".$class."'>";
			echo "<div class='text-left'>";
			echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;' ; 
			echo "</div>";
			echo "</td>";
		}
		
		if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){
			echo "<td align='left'>";
			echo "<div class='tools'>";	
			
			if(!$unset_delete){
				echo "<a href='".$row->delete_url."' title='".$this->l('list_delete')." ".$subject."' class='delete-row btn btn-danger' >";
                echo "<i class='fa fa-trash'></i>";
                echo "</a> ";
			}
			
			if(!$unset_edit){
				echo "<a href='".$row->edit_url."' title='".$this->l('list_edit')." ".$subject."' class='edit_button btn btn-primary'>";
				echo "<i class='fa fa-pencil-square-o'></i>";
				echo "</a> ";
			}
			
			if(!$unset_read){
				echo "<a href='".$row->read_url."' title='".$this->l('list_view')." ".$subject."' class='edit_button btn btn-info'>";
				echo "<i class='fa fa-folder-open-o'></i>";
				echo "</a> ";
			}
			
			if(!empty($row->action_urls)){
				foreach($row->action_urls as $action_unique_id => $action_url){ 
					$action = $actions[$action_unique_id];
					echo "<a href='".$action_url."' class='".$action->css_class." crud-action btn btn-default btn-xs' title='".$action->label."'>";
					if(!empty($action->image_url)){
						echo "<img src='".$action->image_url."' alt='".$action->label."' />";
					}
					echo "</a>";	
				}
			}
			echo "<div class='clear'></div>";
			echo "</div>";
			
		}
		echo "</tr>";
	}
	
	echo "</tbody>";
	echo "</table>";
}else{
	echo setMensaje($this->l('list_no_items'), 'error');
}
?>	
