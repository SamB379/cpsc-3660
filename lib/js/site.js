
$(function(){	
	$.easy.navigation();
	$.easy.tooltip();
	$.easy.popup();
	$.easy.external();
	$.easy.rotate();
	$.easy.cycle();
	$.easy.forms();
	$.easy.showhide();
	$.easy.jump();
	$.easy.tabs();
	$.easy.accordion();	
});
$(document).ready(function() {
	
	$('.datepicker').datepicker({dateFormat: 'yy-mm-dd' });
	
	
	$("input.numeric").keydown(function(event) {
	
        // Allow: backspace, delete, tab and escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
		else if (event.keyCode == 190)
			return;
		
        else {
            // Ensure that it is a number and stop the keypress
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });

	
});