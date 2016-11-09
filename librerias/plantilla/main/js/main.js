/*--------------------------------------------------------------------------------	
 			Validar los input cuando se estan completando
 --------------------------------------------------------------------------------*/	

$(document).ready(function() 
{
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup change', function() {
		var $form = $(this).closest('form'),
            $group = $(this).closest('.input-group'),
			$addon = $group.find('.input-group-addon'),
			$icon = $addon.find('span'),
			state = false;
            
    	if (!$group.data('validate')) 
    	{
			state = $(this).val() ? true : false;
			
		}else if ($group.data('validate') == "email") 
		{
			state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val());
			
		}else if($group.data('validate') == 'phone') 
		{
			state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val());
			
		}else if($group.data('validate') == 'cuit') 
		{
			state = /^\d{2}\-\d{8}\-\d{1}$/.test($(this).val());
			
		}else if($group.data('validate') == 'transaccion') 
		{
			state = /^\d{5}\-\d{5}$/.test($(this).val());
				
		}else if($group.data('validate') == 'unique') 
		{
			if($('#mensaje_error').html() != "")
			{
				state = false;	
			}else 
			{
				state = true;
			}
		}else if ($group.data('validate') == "length") 
		{
			state = $(this).val().length >= $group.data('length') ? true : false;
		}else if ($group.data('validate') == "number") 
		{
			state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
		}

		if (state) 
		{
			$addon.removeClass('danger');
			$addon.addClass('success');
			$icon.attr('class', 'glyphicon glyphicon-ok');
		}else
		{
			$addon.removeClass('success');
			$addon.addClass('danger');
			$icon.attr('class', 'glyphicon glyphicon-remove');
		}
        
        if ($form.find('.input-group-addon.danger').length == 0) 
        {
            $form.find('[type="submit"]').prop('disabled', false);
        }else
        {
            $form.find('[type="submit"]').prop('disabled', true);
        }
	});
    
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');
});

/*--------------------------------------------------------------------------------	
 			Cuando se completa el input solo aceptas numeros
 --------------------------------------------------------------------------------*/	

function onlyInt(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	{
		return false;
	}
	
	return true;
}

/*--------------------------------------------------------------------------------	
 			Cuando se completa el input solo acepta numeros y el punto
 --------------------------------------------------------------------------------*/	

function onlyFloat(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	
	if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
	{
		return false;
	}
	
	return true;
}

/*--------------------------------------------------------------------------------	
 			Cuando se completa el input solo acepta caracteres
 --------------------------------------------------------------------------------*/	

function onlyChar(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if(	255 == charCode ||	// á
		233 == charCode ||	// é
		237 == charCode ||	// í
		243 == charCode ||	// ó
		250 == charCode ||	// ú
		
		193 == charCode ||	// Á
		201 == charCode ||	// É
		205 == charCode ||	// Í
		211 == charCode ||	// Ó
		218 == charCode ){	// Ú
		return true;
	}else if((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 123) && charCode != 32){
		return false;	
	}
    
	return true;
}


/*--------------------------------------------------------------------------------	
 			Cuando se completa el input solo acepta caracteres
 --------------------------------------------------------------------------------*/	

function onlyCharInt(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if(charCode == 32)
	{
		return true;
	}
	
	if(48 <= charCode && charCode <= 57)
	{
		return true;
	}
	
	if(65 <= charCode && charCode <= 90)
	{
		return true;
	}
	
	if(97 <= charCode && charCode <= 122)
	{
		return true;
	}
	
	if(	255 == charCode ||	// á
		233 == charCode ||	// é
		237 == charCode ||	// í
		243 == charCode ||	// ó
		250 == charCode ||	// ú
		
		193 == charCode ||	// Á
		201 == charCode ||	// É
		205 == charCode ||	// Í
		211 == charCode ||	// Ó
		218 == charCode ){	// Ú
			
		return true;
	}
	
	return false;
}

/*--------------------------------------------------------------------------------	
 			Verifica que el valor ingresado sea un entero
 --------------------------------------------------------------------------------*/	

function isInt(value)
{
    var er = /^(?:[1-9]\d*|0)?(?:\.\d+)?$/;

    return er.test(value);
}

/*--------------------------------------------------------------------------------	
 			Verifica que el valor ingresado sea un float
 --------------------------------------------------------------------------------*/	

function isFloat(value)
{
    var er = /^(?:[1-9]\d*|0)?(?:\.\d+)?$/;

    return er.test(value);
}

/*--------------------------------------------------------------------------------	
 			Configuracion de calendarios
 --------------------------------------------------------------------------------*/	

$(document).ready(function() 
{
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '<Ant',
		nextText: 'Sig>',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		weekHeader: 'Sm',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
});

/*--------------------------------------------------------------------------------	
 			Ir arriba button
 --------------------------------------------------------------------------------*/	

$(document).ready(function()
{
	$(window).scroll(function()
	{
		if ($(this).scrollTop() > 100) 
		{
			$('.scrollup').fadeIn();
		}else 
		{
			$('.scrollup').fadeOut();
		}
	});
  
	$('.scrollup').click(function()
	{
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});  
});

/*--------------------------------------------------------------------------------	
 			Seleccionar todos los archivos
 --------------------------------------------------------------------------------*/	

$(function() 
{
	$('#selecctall').click(function(event) 
	{ 
        if(this.checked) 
        { 
            $('.archivos').each(function(){ 
                this.checked = true;  
            });
        }else
        {
            $('.archivos').each(function() { 
                this.checked = false;                  
            });         
        }
    });
});



/*--------------------------------------------------------------------------------	
 			Para dar efectos a los elementos del dom
 --------------------------------------------------------------------------------*/	

$(function() {
	wow = new WOW(
      {
        animateClass: 'animated',
        offset:       100,
        callback:     function(box) {
          console.log("WOW: animating <" + box.tagName.toLowerCase() + ">");
        }
      }
    );
    wow.init();   
});

/*--------------------------------------------------------------------------------	
 			Inicio de los datapicker
 --------------------------------------------------------------------------------*/	

$(function() {
	 $( ".datepicker" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        onClose: function( selectedDate ) {
            $( "#final" ).datepicker( "option", "minDate", selectedDate );
        }
    });
	
    $( ".datepicker_start" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        onClose: function( selectedDate ) {
            $( ".datepicker_end" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( ".datepicker_end" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        onClose: function( selectedDate ) {
            $( ".datepicker_start" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
});