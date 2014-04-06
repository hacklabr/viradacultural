jQuery(document).ready(function() {
  
	jQuery('#mapas_button').click(function() {
		
		var mapas_request;
		var mapas_check_url;
		var mapas_get_images;
		
		jQuery('#mapas_fields').hide();
		jQuery('#mapas_loading').show();
		
		jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            //dataType: 'json',
            data: {
				event_url: jQuery('#mapas_url_evento').val(),
				action: 'mapas_check_event_url'
            },
            
            complete: function(request) {
                if (request.responseText != 'ok') {
                	alert('URL inválida');
                	return;
                }
                
                jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						event_url: jQuery('#mapas_url_evento').val(),
						action: 'mapas_get_event_info'
					},
					
					complete: function(request, status) {
						
						
						if ('success' == status) {
						
							if (confirm('Você tem certeza que deseja atualizar as informações a partir do SP Cultura? Isso irá apagar qualquer alterção manual que você tenha feito.')) {
								var event_info = request.responseJSON;
								
								jQuery('#mapas_titutlo').val(event_info.title);
								jQuery('#mapas_descri_curta').val(event_info.short_description);
								jQuery('#mapas_descri_completa').val(event_info.description);
								jQuery('#mapas_data').val(event_info.date);
								jQuery('#mapas_hora').val(event_info.time);
								jQuery('#mapas_local').val(event_info.place);
								jQuery('#mapas_local_id').val(event_info.place_id);
								
								// Get Images
								jQuery('#mapas_loading').hide();
								jQuery('#mapas_loading_images').show();

								if (event_info.photos.length > 0) {
									for (var foto = 0; foto < event_info.photos.length; foto++) {
										//console.log(event_info.photos[foto]);
										
										jQuery.ajax({
											type: 'POST',
											url: ajaxurl,
											data: {
												image_url: event_info.photos[foto],
												action: 'mapas_get_event_image',
												post_id: jQuery('#post_ID').val()
											},
											
											complete: function(request, status) {
												
												if (foto == event_info.photos.length) {
													jQuery('#mapas_loading').hide();
													jQuery('#mapas_loading_images').hide();
													jQuery('#mapas_fields').show();
												}
												
											}
										});
										
									}
								} else {
									jQuery('#mapas_loading').hide();
									jQuery('#mapas_loading_images').hide();
									jQuery('#mapas_fields').show();
								}
								
							}
							
						}
						
					}
				});
                
            }
        });
        
        jQuery('#mapas_loading').hide();
        jQuery('#mapas_loading_images').hide();
        jQuery('#mapas_fields').show();
		
		
		
	});
	
});
