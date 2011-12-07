
	$(document).ready(function(){

		$('.dev_link_open').click(function(){
			
			$(this).fadeOut(function(){
				$(this).next().fadeIn('slow');	
				$(this).parent().next().fadeIn('slow');
			});
			
			return false;
		});
		
		
		$('.dev_link_close').click(function(){	
			
			var devdiv = $(this);
			
			$(this).parent().next().fadeOut('slow', function(){
				
				devdiv.fadeOut(function(){
					devdiv.prev().fadeIn('slow');	
				});
					
			});
			
			return false;
		});
		
		
	 });
