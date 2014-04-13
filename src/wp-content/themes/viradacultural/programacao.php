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
                    <h4 class="modal-title" id="myModalLabel">Mapa da Virada</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="list-group">
                        <a href="#" class="list-group-item"
                           ng-class="{active: space.selected}"
                           ng-repeat="space in spaces"
                           ng-click="toggleSelectSpace(space)">{{space.name}}</a>
                    </div>
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
                            ng-click="$parent.filters.spaces = countSelected() > 0">Ver programação</button>
                </div>
            </div>
        </div>
        <!-- .modal-dialog -->
    </div>
    <!-- #map-modal -->
    <nav id="programacao-navbar" class="virada-navbar navbar navbar-fixed-top">
        <div class="container-fluid container-menu-minified">
            <div class="row">
                <h1 class="programacao-navbar-item">Programação
                <a class="btn btn-primary" ng-if="conf.pdfURL" href="{{conf.pdfURL}}"><span class="icon icon_download" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Baixar a programação"></span> </a></h1>
                <div id="sort-by" class="programacao-navbar-item">
                    <span>Por:</span>
                    <!--<select class="form-control" ng-model="viewBy" style="width: initial;">
                        <option value="space">local</option>
                        <option value="name">atração</option>
                        <option value="time">horário</option>
                    </select>-->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Local <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Local</a></li>
                            <li><a href="#">Atração</a></li>
                            <li><a href="#">Horário</a></li>
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
                    <a id="grid-view" ng-class='{"active": viewMode === "grid"}' ng-click="viewMode = 'grid'"><span class="icon icon_grid-2x2"></span></a>
                    <a id="list-view" ng-class='{"active": viewMode === "list"}' ng-click="viewMode = 'list'"><span class="icon icon_menu-square_alt"></span></a>
                </div>
            </div>
            <!-- .row -->
        </div>
        <!-- .container-fluid -->
    </nav>
    <!-- #programacao-navbar -->
    <div id="programacao-container" class="container-fluid container-menu-minified">
        <div class="row">
            <section id="main-section" class="panel-group">
                <!-- here begins the panel on grid view mode by space-->
                <div class="panel panel-default hl-carrousel" ng-show="viewBy === 'space' && viewMode === 'grid'" on-last-repeat  ng-repeat="space in searchResult" ng-show="!filters.spaces || (filters.spaces && space.isSelected())">
                    <div class='hl-ref'></div>
                    <div class="panel-heading clearfix">
                        <h4 class="alignleft panel-title">
                            <a href="{{spaceUrl(space.id)}}">{{space.name}}</a>
                        </h4>
                        <a class="alignright" data-toggle="collapse" data-parent="#main-section" href="#space-{{space.id}}">
                            <span class="icon arrow_carrot-down_alt2"></span>
                        </a>
                    </div>
                    <div id="space-{{space.id}}" class="panel-collapse">
                        <div class="program-nav program-nav-left hl-nav prev" ><span class="icon arrow_carrot-left"></span></div>
                        <div class="program-nav program-nav-right hl-nav next" ><span class="icon arrow_carrot-right"></span></div>
                        <ul class="numeric-nav hl-num-nav"></ul>
                        <div class="panel-body hl-wrap">
                            <article class="event clearfix event-grid" ng-repeat="event in space.events">
                                    <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                                <div class="event-content clearfix">
                                        <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                                    <footer class="clearfix">
                                        <span class="alignleft"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                                        <a class="alignright icon icon_star_alt" href="#" ng-click="favorite(event.id)"></a>
                                    </footer>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <!-- .panel-->
                <!-- here begins the panel on list view mode by space-->
                <div class="panel panel-default" ng-if="viewBy === 'space' && viewMode === 'list'" ng-repeat="space in searchResult" ng-show="!filters.spaces || (filters.spaces && space.isSelected())">
                    <div class="panel-heading clearfix">
                        <h4 class="alignleft panel-title">
                            <a href="{{spaceUrl(space.id)}}">{{space.name}}</a>
                        </h4>
                        <a class="alignright" data-toggle="collapse" data-parent="#main-section" href="#space-{{space.id}}">
                            <span class="icon arrow_carrot-down_alt2"></span>
                        </a>
                    </div>
                    <div id="space-{{space.id}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <article class="event clearfix event-list" ng-repeat="event in space.events">
                                    <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                                <div class="event-content clearfix">
                                        <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                                    <footer class="clearfix">
                                        <span class="alignleft"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                                        <a class="alignright icon icon_star_alt" href="#" ng-click="favorite(event.id)"></a>
                                    </footer>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <!-- .panel-->
                <!-- here begins the panel on grid or list view mode by time-->
                <div ng-if="viewBy === 'time'">
                    <article class="event clearfix" ng-repeat="event in searchResultEventsByTime"  on-last-repeat ng-class="{'event-grid': viewMode === 'grid', 'event-list': viewMode === 'list'}">
                        <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                        <div class="event-content clearfix">
                                <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                            <footer class="clearfix">
                                <span class="alignleft"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                                <a class="alignright icon icon_star_alt" href="#"></a>
                            </footer>
                        </div>
                    </article>
                </div>
                <!-- .panel-->
                <!-- here begins the panel on grid or list view mode by alphabetical order-->
                <div ng-if="viewBy === 'name'">
                    <article class="event clearfix" ng-repeat="event in searchResultEventsByName" on-last-repeat ng-class="{'event-grid': viewMode === 'grid', 'event-list': viewMode === 'list'}">
                        <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                        <div class="event-content clearfix">
                                <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                            <footer class="clearfix">
                                <span class="alignleft"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                                <a class="alignright icon icon_star_alt" href="#"></a>
                            </footer>
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