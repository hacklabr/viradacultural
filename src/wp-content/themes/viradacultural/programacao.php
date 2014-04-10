<?php get_header(); ?>
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
                            <p><a href="#">mais info</a></p>
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
</div>
<nav id="programacao-navbar" class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="col-md-offset-1">
            <h1>Programação</h1>
            <div id="view-btn-group" class="btn-group">
                <button id="grid-view" type="button" class="btn btn-secondary" ng-class='{"active": viewMode === "grid"}' ng-click="viewMode = 'grid'"><span class="icon icon_grid-2x2"></span></button>
                <button id="list-view" type="button" class="btn btn-secondary" ng-class='{"active": viewMode === "list"}' ng-click="viewMode = 'list'"><span class="icon icon_menu-square_alt"></span></button>
            </div>
            <form id="programacao-search" class="programacao-navbar-item" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Digite uma palavra-chave" ng-model='searchText' ng-change='populateEntities()'>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><span class="icon icon_search"></span></button>
                    </span>
                </div>
            </form>
            <form class="clearfix programacao-navbar-item" role="time-filter">
                <div class="input-group bootstrap-timepicker">
                    <input id="timepicker-start" type="text" class="form-control timepicker-field" data-minute-step="5" data-show-meridian="false" ng-model="startsAt" ng-change="changeStartsAt()">
                    <span class="input-group-addon"><span class="icon icon_clock"></span></span>
                </div>
                <span class="navbar-left navbar-text"> às </span>
                <div class="input-group bootstrap-timepicker">
                    <input id="timepicker-end" type="text" class="form-control timepicker-field" data-minute-step="5" data-show-meridian="false" ng-model="endsAt" ng-change="changeEndsAt()">
                    <span class="input-group-addon"><span class="icon icon_clock"></span></span>
                </div>
            </form>
            <div class="programacao-navbar-item">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#map-modal" ng-click="filters.spaces=true"><span class="icon icon_pin"></span> Filtrar Locais</button>
            </div>
            <div class="programacao-navbar-item" ng-if="conf.pdfURL">
                <a href="{{conf.pdfURL}}" role="button" class="btn btn-primary"><span class="icon icon_download"></span> Baixar PDF</a>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <section id="main-section" class="panel-group col-md-11 col-md-offset-1">
            <div class="panel panel-default" ng-repeat="space in searchResult"
                 ng-show="!filters.spaces || (filters.spaces && space.isSelected())">

                <div class="panel-heading clearfix">
                    <h4 class="alignleft panel-title">
                        <a class="icon icon_pin" href="#" data-toggle="modal" data-target="#map-modal"></a> <a href="{{conf.templateURL}}/programacao/locais/slug-do-local">{{space.name}}</a>{{space.selected}}
                    </h4>
                    <a class="alignright" data-toggle="collapse" data-parent="#main-section" href="#space-{{space.id}}">
                        <span class="icon arrow_carrot-down_alt2"></span>
                    </a>
                </div>
                <div id="space-{{space.id}}" class="panel-collapse collapse">
                    <div class="program-nav program-nav-left" ng-show='viewMode === "grid"'><span class="icon arrow_carrot-left"></span></div>
                    <div class="program-nav program-nav-right" ng-show='viewMode === "grid"'><span class="icon arrow_carrot-right"></span></div>
                    <div class="panel-body">
                        <article class="event clearfix" ng-repeat="event in space.events" ng-class="{'event-grid': viewMode === 'grid', 'event-list': viewMode === 'list'}">
                            <img src="../wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                            <div class="event-content clearfix">
                                <h1><a href="{{conf.templateURL}}/programacao/atracoes/slug-da-atracao">{{event.name}}</a></h1>
                                <footer class="clearfix">
                                    <span class="alignleft"><span class="icon icon_clock"></span> <time>{{event.startsAt}}</time></span>
                                    <a class="alignright icon icon_star" href="#"></a>
                                </footer>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        <!-- #main-section -->
    </div>
    <!-- .row -->
</div>
<!-- .container-fluid -->
<?php get_footer(); ?>
