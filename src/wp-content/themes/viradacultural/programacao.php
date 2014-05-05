<?php get_header(); ?>
<div ng-controller='programacao'>
    <div id="map-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true"
         ng-controller="SpacesFilter" modal-shown="redrawMap()">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            ng-click="$parent.filters.spaces = $parent.filters.spaces && countSelected() > 0"><span class="icon icon_close"></span></button>
                    <h4 class="modal-title" id="myModalLabel">Filtro de Locais <small class="hidden-xs">Clique no nome ou no pin do local para selecioná-lo</small></h4>
                </div>
                <!-- .modal-header -->
                <div class="modal-body clearfix">
                    <ul class="nav nav-pills visible-xs">
                        <li class="active"><a href="#modal-list" data-toggle="pill">Lista</a></li>
                        <li><a href="#modal-map" data-toggle="pill">Mapa</a></li>
                    </ul>
                    <div class="tab-content clearfix">
                        <nav id="modal-list" class="modal-nav tab-pane active">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Encontre um local" ng-model="filterSpace">
                                <span class="input-group-addon"><span class="icon icon_search"></span></span>
                            </div>
                            <div class="list-group" id="fl-list-spaces">
                                <a href="#" class="list-group-item"
                                   id="fl-list-item-{{space.id}}"
                                   ng-class="{active: space.selected}"
                                   ng-repeat="space in spacesByName | filter:filterSpace"
                                   ng-click="toggleSelectSpace(space)">{{space.name}}</a>
                            </div>
                        </nav>
                        <div id="modal-map" class="mapa google-map tab-pane"
                                center="map.center"
                                control="map.control"
                                zoom="map.zoom"
                                draggable="true"
                                refresh="true"
                                ng-class="{'active': !midgetDevice}"
                                >



                            <marker ng-repeat="space in spaces"
                                    coords="space.location"
                                    icon="space.selected ? marker.icon.selected : marker.icon.default"
                                    options="marker.options"
                                    events="marker.events"
                                    click="showSpaceInfo(space)">

                                <window show="space.showInfo"
                                        isIconVisibleOnClick="true"
                                        options="infowindow.options"
                                        closeClick="hideSpaceInfo(space)">
                                    <h5 class="map-space-title">{{space.name}}</h5>
                                    <p class="textcenter"><a class="btn btn-primary btn-xs" fl-space-id="{{space.id}}">selecionar</a></p>
                                </window>
                            </marker>




                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            ng-click="$parent.filters.spaces=false" ng-class="{'btn-xs': midgetDevice}">Cancelar</button>

                    <button type="button" class="btn btn-default" ng-click="deselectAll()" ng-class="{'btn-xs': midgetDevice}">Limpar seleção</button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                            ng-click="$parent.filters.spaces = countSelected() > 0; populateEntities();" ng-class="{'btn-xs': midgetDevice}">Filtrar</button>
                </div>
            </div>
        </div>
        <!-- .modal-dialog -->
    </div>
    <!-- #map-modal -->
    <!-- LARGE DEVICES -->
    <nav id="programacao-navbar" class="collapse navbar-collapse virada-navbar navbar navbar-fixed-top">
        <div class="container-fluid container-menu-minified">
            <div class="row">
                <h1 class="programacao-navbar-item visible-md visible-lg">Programação
                <a class="icon icon_download" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Baixar a programação"></a></h1>
                <div id="programacao-search" class="programacao-navbar-item" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar eventos" ng-model='data.searchText' ng-change='populateEntities()'>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><span class="icon icon_search" data-toggle="tooltip" data-container="body" data-placement="bottom" title="Encontrar eventos por palavra-chave"></span></button>
                        </span>
                    </div>
                </div>
                <div id="by-group" class="programacao-navbar-item">
                    <span class="hidden-md">Por:</span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            {{viewByLabels[data.viewBy]}}  <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" ng-click="data.viewBy = 'space'">Por Local</a></li>
                            <li><a href="#" ng-click="data.viewBy = 'name'">Por Atração</a></li>
                            <li><a href="#" ng-click="data.viewBy = 'time'">Por Horário</a></li>
                        </ul>
                    </div>
                </div>
                <div id="space-filter" class="programacao-navbar-item">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="icon icon_pin"></span> <span class="hidden-md">Filtrar locais </span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" data-toggle="modal" data-target="#map-modal" ng-click="nearMe()">Próximo a mim</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#map-modal" ng-click="filters.spaces=true">Selecionar locais</a></li>
                        </ul>
                    </div>
                </div>
                <div id="time-filter-item" class="programacao-navbar-item">
                    <div class="time-filter-group clearfix">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="icon icon_clock" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Filtrar horário"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <div show-values="false" range-slider prevent-equal-min-max="true" min="timeSlider.range.min" max="timeSlider.range.max" model-min="timeSlider.model.min" model-max="timeSlider.model.max" step="1"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="time-filter clearfix">
                            <div class="time-range time-range-start">
                                {{startsAt}}
                            </div>

                            <div class="navbar-text">às</div>

                            <div class="time-range time-range-end">
                                {{endsAt}}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="view-group" class="visible-md visible-lg">
                    <a id="grid-view" ng-class='{"active": data.viewMode === "grid"}' ng-click="data.viewMode = 'grid'"><div class="icon icon_grid-2x2"></div></a>
                    <a id="list-view" ng-class='{"active": data.viewMode === "list"}' ng-click="data.viewMode = 'list'"><div class="icon icon_menu-square_alt"></div></a>
                </div>
            </div>
            <!-- .row -->
        </div>
        <!-- .container-fluid -->
    </nav>
    <!-- #programacao-navbar -->



    <div id="programacao-container" class="container-fluid container-menu-minified">
        <div class="row">
            <section id='programacao-loading'></section>
            <section id="main-section" class="panel-group">

            </section>
            <!-- #main-section -->
        </div>
        <!-- .row -->
    </div>
    <!-- #programacao-container.container-fluid -->
</div>


<script type="text/html" id="template-space-grid">
    <div id="programacao-grid" class="panel panel-default hl-carrousel">
        <div class="hl-ref"></div>
        <div class="panel-heading clearfix">
            <h4 class="alignleft panel-title">
                <a href="<%=url%>"><%=name%></a>
            </h4>

            <a class="alignright" data-toggle="collapse" data-target="#grid-space-<%=id%>">
                <span class="icon arrow_carrot-down_alt2"></span>
            </a>
        </div>
        <div id="grid-space-<%=id%>" class="panel-collapse collapse in">
            <div class="program-nav program-nav-left hl-nav prev" ><span class="icon arrow_carrot-left"></span></div>
            <div class="program-nav program-nav-right hl-nav next" ><span class="icon arrow_carrot-right"></span></div>
            <ul class="numeric-nav hl-num-nav"></ul>
            <div class="panel-body hl-wrap js-events-container"></div>
        </div>
    </div>
</script>

<script type="text/html" id="template-space-list">
    <div id="programacao-list" class="panel panel-default">
        <div class="hl-ref"></div>
        <div class="panel-heading clearfix">
            <h4 class="alignleft panel-title">
                <a href="<%=url%>"><%=name%></a>
            </h4>
            <a class="alignright" data-toggle="collapse" data-target="#grid-space-<%=id%>">
                <span class="icon arrow_carrot-down_alt2"></span>
            </a>
             <?php if (current_user_can('edit_posts') && defined('MAPASCULTURAIS_URL') ): ?>
                <small class="hidden js-edit" data-e="espacos|<%=id%>"></small>
            <?php endif; ?>
        </div>
        <div id="grid-space-<%=id%>" class="panel-collapse collapse in">
            <div class="panel-body hl-wrap js-events-container"></div>
        </div>
    </div>
</script>

<script type="text/html" id="template-event-grid">
    <article class="event clearfix event-grid <% if(duration === '24h00') { %> evento-24h <% } %> <% if (!defaultImageThumb) { %> no-thumb <% } %>">
        <span class="event-time">
            <span class="icon icon_clock"></span>
            <% if(duration === '24h00') { %>
                <time>24 horas</time>
            <% } else { %>
                <time><%=startsAt%></time>
            <% } %>
        </span>

        <img src="<%=defaultImageThumb%>"/>

        <div class="event-content clearfix">

            <h1>
                <a href="<%=url%>"><%=name%></a>
            </h1>
            <a class="icon favorite favorite-event-<%=id%>" onClick="minhaVirada.click(<%=id%>)"><!--qdo selecionado adicionar classe active--></a>
        </div>
    </article>
</script>


<script type="text/html" id="template-event-list">
    <article class="event clearfix event-list <% if(duration === '24h00') { %> evento-24h <% } %>">
        <span class="event-time">
            <span class="icon icon_clock"></span>
            <% if(duration === '24h00') { %>
                <time>24 horas</time>
            <% } else { %>
                <time><%=startsAt%></time>
            <% } %>
        </span>

        <div class="event-content clearfix">

            <h1>
                <a href="<%=url%>"><%=name%></a>
                    <small class="alignright hidden js-edit" data-e="eventos|<%=id%>"></small>
            </h1>
            <a class="icon favorite favorite-event-<%=id%>" onClick="minhaVirada.click(<%=id%>)"><!--qdo selecionado adicionar classe active--></a>

        </div>
    </article>
</script>
<script>
document.addEventListener('keyup', function(e){
    if(e.ctrlKey && e.shiftKey && e.altKey && e.keyCode == 69){
        jQuery('.js-edit').html( function (){
            return atob('<?php echo base64_encode ('&nbsp; (<a href="'.MAPASCULTURAIS_URL.'/<%=e%>/edita/<%=id%>">Editar</a>)');?>')
                .replace('<%=e%>', jQuery(this).data('e').split('|')[0])
                .replace('<%=id%>', jQuery(this).data('e').split('|')[1])
            }
        ).removeClass('hidden');
    }
});
</script>
<?php get_footer(); ?>
