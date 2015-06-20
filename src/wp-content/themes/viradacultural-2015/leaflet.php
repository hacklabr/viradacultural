<?php
/*
Template Name: Leaflet
*/
?>
<!-- .container-fluid -->

<?php get_header(); ?>
<div class="js-leaflet">
<div class="container-fluid container-menu-large">
    <div id="leaflet-container"></div>
    <!-- #main-section -->
    <?php get_footer(); ?>
</div>
<!-- .container-fluid -->
</div>
<?php html::part('countdown'); ?>
<script>
    (function($){
        'use strict';

        $(function() {
            var map = L.map('leaflet-container').setView([-23.5507,-46.6334], 14);

            $('#leaflet-container').height($(window).height() - $('#main-footer').innerHeight());
            map.invalidateSize();

            var layersPath = 'http://viradacultural.prefeitura.sp.gov.br/2015/api/map/';
            var baseLayer = L.tileLayer('https://{s}.tiles.mapbox.com/v4/duncangraham.b134a19e/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImdQMzI4WjgifQ.d-Uyr7NBjrJVz9z82uk5Xg', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var tileLayers = ['wifi', 'alimentacao', 'postos', 'banheiros', 'ambulancia_uti', 'ambulancia'];
            var tileLayersReadable = ['WiFi', 'Alimentação', 'Postos Médicos', 'Banheiros', 'Ambulâncias UTIs', 'Ambulâncias Básicas'];
            var controlLayers = {};
            $.each(tileLayers, function(key, item){
                var smallIcon = new L.Icon({
//                    iconSize: [27, 27],
//                    iconAnchor: [13, 27],
//                    popupAnchor:  [1, -24],
                    iconUrl: 'http://viradacultural.prefeitura.sp.gov.br/2015/api/map/icons/' + item + '.png'
                });
                $.getJSON(layersPath + item + '.json', function(data) {
                    var myLayer = L.geoJson(data, {
                        pointToLayer: function (feature, latlng) {
                            return L.marker(latlng, {
                                icon: smallIcon
                            });
                        },
                        onEachFeature: function (feature, layer) {
                            layer.bindPopup(feature.properties.name);
                        }
                    });
                    controlLayers[tileLayersReadable[key]] = myLayer;
                    myLayer.addTo(map);
                })
                .always(function() {
                    if (key === tileLayers.length - 1) {
                        var layersControl = new L.Control.Layers({}, controlLayers).addTo(map);
                    }
                });
            });
            $(window).on('resize', function(){
                map.invalidateSize();
            });
        });
    })(jQuery);
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
<style>
    @import "//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css";
    #leaflet-container {
        width: 100%;
    }

</style>
