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
					action: 'get_nasredes_novidades'
				},
				
				complete: function(request, status) {
					var results = request.responseJSON;
					if (results.length > 0) {
						fila = fila.concat(results);
						last_id = fila[fila.length-1];
					}
					
				}
			});
		}
		
		
		var imprimeNovidades = function (){
			if (fila.length > 0) {
				var novo = fila.shift();
				$.ajax({
					type: 'POST',
					url: vars.ajaxurl,
					data: {
						post_id: novo,
						action: 'get_nasredes_post'
					},
					
					complete: function(request, status) {
						var post = request.responseText;
						if (post != '') 
							$('#main-section').prepend(post);
						
						setTimeout(imprimeNovidades, Math.floor((Math.random()*5)+1)*1000);
						
					}
				});
			} else {
				setTimeout(imprimeNovidades, Math.floor((Math.random()*5)+1)*1000);
			}
		}
		
		//init
		setInterval(buscaNovidades, 5000);
		setTimeout(imprimeNovidades, 7000);

    })
})(jQuery);
