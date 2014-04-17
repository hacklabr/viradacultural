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
                    <h4 class="modal-title" id="myModalLabel">Filtro de Locais <small>Clique no nome ou no pin do local para selecioná-lo</small></h4>
                </div>
                <div class="modal-body clearfix">
                    <nav class="modal-nav">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Encontre um local" ng-model="filterSpace">
                            <span class="input-group-addon"><span class="icon icon_search"></span></span>
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item"
                               ng-class="{active: space.selected}"
                               ng-repeat="space in spacesByName | filter:filterSpace"
                               ng-click="toggleSelectSpace(space)">{{space.name}}</a>
                        </div>
                    </nav>
                    <div class="mapa google-map"
                            center="map.center"
                            control="map.control"
                            zoom="map.zoom"
                            draggable="true"
                            refresh="true">

                        <marker ng-repeat="space in spaces"
                                coords="space.location"
                                icon="space.selected ? icons.selected : icons.default"
                                click="showSpaceInfo(space)">

                            <window show="space.showInfo"
                                    isIconVisibleOnClick="true"
                                    closeClick="hideSpaceInfo(space)">
                                <h3>{{space.name}}</h3>
                                <p>{{space.shortDescription}}</p>
                                <p><a href="{{spaceUrl(space.id)}}" target="_blank">mais info</a></p>
                            </window>
                        </marker>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            ng-click="$parent.filters.spaces=false">Cancelar</button>

                    <button type="button" class="btn btn-default" ng-click="deselectAll()">Limpar seleção</button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                            ng-click="$parent.filters.spaces = countSelected() > 0">Aplicar filtro</button>
                </div>
            </div>
        </div>
        <!-- .modal-dialog -->
    </div>
    <!-- #map-modal -->
    <!-- LARGE DEVICES -->
    <nav id="programacao-navbar" class="virada-navbar navbar navbar-fixed-top hidden-sm hidden-xs" ng-show="!smallDevice" >
        <div class="container-fluid container-menu-minified">
            <div class="row">
                <h1 class="programacao-navbar-item">Programação
                <a class="btn btn-primary" ng-if="conf.pdfURL" href="{{conf.pdfURL}}"><span class="icon icon_download" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Baixar a programação"></span> </a></h1>
                <div class="programacao-navbar-item">
                    <span>Por:</span>
                    <!--<select class="form-control" ng-model="viewBy" style="width: initial;">
                        <option value="space">local</option>
                        <option value="name">atração</option>
                        <option value="time">horário</option>
                    </select>-->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                          {{viewByLabels[viewBy]}}  <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" ng-click="viewBy='space'">Local</a></li>
                            <li><a href="#" ng-click="viewBy='name'">Atração</a></li>
                            <li><a href="#" ng-click="viewBy='time'">Horário</a></li>
                        </ul>
                    </div>
                </div>
                <div id="space-filter" class="programacao-navbar-item">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#map-modal" ng-click="filters.spaces=true"><span class="icon icon_pin" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Filtrar espaços"></span></button>
                </div>
                <div class="col-md-4 programacao-navbar-item">

                    <div class="time-filter-group clearfix">
                        <button type="button" class="btn btn-primary"><span class="icon icon_clock" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Filtrar horários"></span></button>
                        <div class="time-filter clearfix">
                            <div class="time-range time-range-start">
                                {{startsAt}}
                            </div>
                            <div show-values="false" range-slider prevent-equal-min-max="true" min="timeSlider.range.min" max="timeSlider.range.max" model-min="timeSlider.model.min" model-max="timeSlider.model.max" step="1"></div>
                            <div class="time-range time-range-end">
                                {{endsAt}}
                            </div>
                        </div>
                    </div>
                </div>

                <div id="programacao-search" class="col-md-2 programacao-navbar-item" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar eventos" ng-model='searchText' ng-change='populateEntities()'>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><span class="icon icon_search" data-toggle="tooltip" data-container="body" data-placement="bottom" title="Encontrar eventos por palavra-chave"></span></button>
                        </span>
                    </div>
                </div>

                <div id="view-group" class="col-md-1">
                    <a id="grid-view" ng-class='{"active": viewMode === "grid"}' ng-click="viewMode('grid')"><span class="icon icon_grid-2x2"></span></a>
                    <a id="list-view" ng-class='{"active": viewMode === "list"}' ng-click="viewMode('list')"><span class="icon icon_menu-square_alt"></span></a>
                </div>
            </div>
            <!-- .row -->
        </div>
        <!-- .container-fluid -->
    </nav>
    <!-- #programacao-navbar -->


    <div id="programacao-container" class="container-fluid container-menu-minified">
        <div class="row">
            <section id="main-section" class="panel-group hidden-sm hidden-xs">
                <!-- here begins the panel on grid view mode by space-->
                <div id="programacao-grid" class="panel panel-default hl-carrousel" ng-if="viewBy === 'space' && viewMode === 'grid'" ng-repeat="space in searchResult" on-last-repeat ng-show="!filters.spaces || (filters.spaces && space.isSelected())">
                    <div class='hl-ref'></div>
                    <div class="panel-heading clearfix">
                        <h4 class="alignleft panel-title">
                            <a href="{{spaceUrl(space.id)}}" target="_blank">{{space.name}}</a>
                        </h4>
                        <a class="alignright" data-toggle="collapse" data-target="#grid-space-{{space.id}}">
                            <span class="icon arrow_carrot-down_alt2"></span>
                        </a>
                    </div>
                    <div id="grid-space-{{space.id}}" class="panel-collapse collapse in">
                        <div class="program-nav program-nav-left hl-nav prev" ><span class="icon arrow_carrot-left"></span></div>
                        <div class="program-nav program-nav-right hl-nav next" ><span class="icon arrow_carrot-right"></span></div>
                        <ul class="numeric-nav hl-num-nav"></ul>
                        <div class="panel-body hl-wrap">
                            <article class="event clearfix event-grid" ng-repeat="event in space.events">
                                <span class="event-time"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                                <img data-original="{{event.defaultImageThumb}}" class="lazy"/>
<!--                                <img ng-src="{{event.defaultImageThumb}}"/>-->

                                <div class="event-content clearfix">
                                    <h1><a href="{{eventUrl(event.id)}}" target="_blank">{{event.name}}</a></h1>
                                    <a class="icon favorite favorite-event-{{event.id}}" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
            <section id="list-main-section" class="panel-group">
                <!-- .panel-->
                <!-- here begins the panel on list view mode by space-->
                <div id="programacao-list" class="panel panel-default" ng-if="viewBy === 'space' && viewMode === 'list'" ng-repeat="space in searchResult" on-last-repeat ng-show="!filters.spaces || (filters.spaces && space.isSelected())">
                    <div class="panel-heading clearfix">
                        <h4 class="alignleft panel-title">
                            <a href="{{spaceUrl(space.id)}}" target="_blank">{{space.name}}</a>
                        </h4>
                        <a class="alignright" data-toggle="collapse" data-target="#list-space-{{space.id}}">
                            <span class="icon arrow_carrot-down_alt2"></span>
                        </a>
                    </div>
                    <div id="list-space-{{space.id}}" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <article class="event clearfix event-list" ng-repeat="event in space.events">
                                <span class="event-time"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                                <div class="event-content clearfix">
                                    <h1><a href="{{eventUrl(event.id)}}" target="_blank">{{event.name}}</a></h1>
                                    <a class="icon favorite favorite-event-{{event.id}}" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <!-- .panel-->
                <!-- here begins the panel on grid or list view mode by time-->
                <div ng-if="viewBy === 'time'">
                    <article class="event clearfix" ng-repeat="event in searchResultEventsByTime"  on-last-repeat ng-class="{'event-grid': viewMode === 'grid', 'event-list': viewMode === 'list'}" ng-show="!filters.spaces || (filters.spaces && event.isInFilteredSpaces() )">
                        <span class="event-time"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                        <img data-original="{{event.defaultImageThumb}}" class="lazy"/>
<!--                        <img ng-src="{{event.defaultImageThumb}}"/>-->
                        <div class="event-content clearfix">
                            <h1><a href="{{eventUrl(event.id)}}" target="_blank">{{event.name}}</a></h1>
                            <a class="icon favorite favorite-event-{{event.id}}" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
                        </div>
                    </article>
                </div>
                <!-- .panel-->
                <!-- here begins the panel on grid or list view mode by alphabetical order-->
                <div ng-if="viewBy === 'name'">
                    <article class="event clearfix" ng-repeat="event in searchResultEventsByName" on-last-repeat ng-class="{'event-grid': viewMode === 'grid', 'event-list': viewMode === 'list'}" ng-show="!filters.spaces || (filters.spaces && event.isInFilteredSpaces() )">
                        <span class="event-time"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                        <img data-original="{{event.defaultImageThumb}}" class="lazy"/>
<!--                        <img ng-src="{{event.defaultImageThumb}}"/>-->
                        <div class="event-content clearfix">
                            <h1><a href="{{eventUrl(event.id)}}" target="_blank">{{event.name}}</a></h1>
                            <a class="icon favorite favorite-event-{{event.id}}" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
                        </div>
                    </article>
                </div>

            </section>
            <!-- #main-section -->
        </div>
        <!-- .row -->
        <center>
    </div>
    <!-- #programacao-container.container-fluid -->
</div>
<?php get_footer(); ?>
