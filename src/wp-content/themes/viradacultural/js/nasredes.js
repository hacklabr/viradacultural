(function($){
    $(document).ready(function(){

        var fila = new Array();
        
        
        var last_id = $('#main-section > article:first').attr('id').replace('post-', '');
        if (!last_id) last_id = 0;
        
        var buscaNovidades = function () {
			$.ajax({
				type: 'POST',
				url: vars.ajaxurl,
				data: {
					last_id: last_id,
					action: 'get_nasredes_posts'
				},
				
				complete: function(request, status) {
					var results = request.responseText;
					if (results != '') {
						$('#main-section').prepend(results);
						last_id = $('#main-section > article:first').attr('id').replace('post-', '');
					}
					
				}
			});
		}
		
		
		var imprimeNovidades = function (){
			
            if ($('#main-section > article:visible').eq(0).prev().size() > 0) {
                $('#main-section > article:visible').eq(0).prev().fadeIn();
            }
        
            setTimeout(imprimeNovidades, Math.floor((Math.random()*5)*1000));
        
		}
		
		//init
		setInterval(buscaNovidades, 5000);
		setTimeout(imprimeNovidades, 7000);

    })
})(jQuery);
