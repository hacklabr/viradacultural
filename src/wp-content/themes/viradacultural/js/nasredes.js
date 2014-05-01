(function($){
    $(document).ready(function(){

        var fila = new Array();
        
        var buscaNovidades = function () {
			$.ajax({
				type: 'POST',
				url: GlobalConfiguration.templateURL + '/includes/nas-redes-ajax.php',
				data: {
					last_id: $('#main-section > article:first').attr('id').replace('post-', ''),
					action: 'get_nasredes_posts',
                    what: 'newer'
				},
				
				complete: function(request, status) {
					var results = request.responseText;
					if (results != '') {
						$('#main-section').prepend(results);
                        window.adustGridHeight();					
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
        
        $('#load-more').click(function() {
            var $botao = $(this);
            $botao.html('Carregando').removeClass('btn-default').addClass('btn-info');
            
            $.ajax({
				type: 'POST',
				url: GlobalConfiguration.templateURL + '/includes/nas-redes-ajax.php',
				data: {
					last_id: $('#main-section > article:last').attr('id').replace('post-', ''),
					action: 'get_nasredes_posts',
                    what: 'older'
				},
				
				complete: function(request, status) {
					var results = request.responseText;
					if (results != '') {
						$('#main-section').append(results);
						$botao.html('Carregar mais').removeClass('btn-info').addClass('btn-default');
                        window.adustGridHeight();
					} else {
                        $botao.html('Não há mais novidades').removeClass('btn-info').addClass('btn-warning');
                    }
					
				}
			});
        });
        
		
		//init
		var buscandoNovidades = setInterval(buscaNovidades, 5000);
		setTimeout(imprimeNovidades, 7000);
        
        //$('#panic').click(function(){ clearInterval(buscandoNovidades) });

    })
})(jQuery);
