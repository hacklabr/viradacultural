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
    </div>
    <nav id="programacao-navbar" class="virada-navbar navbar navbar-fixed-top">
        <div class="container-fluid">
            <h1 class="">Programação <a ng-if="conf.pdfURL" href="{{conf.pdfURL}}" class="icon icon_download"></a></h1>
            <div id="view-btn-group" class="btn-group">
                <button id="grid-view" type="button" class="btn btn-secondary" ng-class='{"active": viewMode === "grid"}' ng-click="viewMode = 'grid'"><span class="icon icon_grid-2x2"></span></button>
                <button id="list-view" type="button" class="btn btn-secondary" ng-class='{"active": viewMode === "list"}' ng-click="viewMode = 'list'"><span class="icon icon_menu-square_alt"></span></button>
            </div>
            <div id="programacao-search" class="programacao-navbar-item" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Digite uma palavra-chave" ng-model='searchText' ng-change='populateEntities()'>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><span class="icon icon_search"></span></button>
                    </span>
                </div>
            </div>
            <div class="clearfix programacao-navbar-item" role="time-filter">
                <div><span class="icon icon_clock"></span></div>
                <div>{{startsAt}}</div>
                <div range-slider show-values="false" prevent-equal-min-max="true" min="timeSlider.range.min" max="timeSlider.range.max" model-min="timeSlider.model.min" model-max="timeSlider.model.max" step="1"></div>
                <div>{{endsAt}}</div>
            </div>
            <div class="programacao-navbar-item">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#map-modal" ng-click="filters.spaces=true"><span class="icon icon_pin"></span> Filtrar Locais</button>
            </div>

            <div class="programacao-navbar-item">
                <span class="navbar-text">Por</span>
                <select class="form-control">
                    <option>local</option>
                    <option>atração</option>
                    <option>horário</option>
                </select>
            </div>
        </div>
    </nav>
    <div class="container-fluid">

        <!-- -----------------------------
        <section id="destaques-da-agenda" class="home-section">
            <div class="wrap hl-carrousel clearfix">
                <div class='hl-ref'></div>
                <h2 class="titulo-editoria clearfix">
                    <a href="#" class="titulo">Destaques da Agenda</a>
                </h2>
                <div class="hl-wrap clearfix">
                    <article id="post-594285" class="post-594285 post type-post status-publish format-standard hentry category-saiba-antes tag-news tag-primeira-vez-no-brasil tag-salvador-dali tag-teatro-museu-dali-de-figueras post clearfix grid category-agenda has-thumbnail">
                        <div class="splash">Saiba Antes</div>
                        <a href="http://catracalivre.com.br/geral/saiba-antes/indicacao/em-maio-exposicao-do-dali-chega-ao-brasil/" title="Em maio, exposi&ccedil;&atilde;o do Dal&iacute; chega ao Brasil "><img width="330" height="180" src="http://catracalivre.com.br/wp-content/plugins/lazy-load/images/1x1.trans.gif" data-lazy-src="http://catracalivre.com.br/wp-content/uploads/2014/03/dali_divulgacao-330x180.jpg" class="attachment-grid4-medio wp-post-image" alt="dali_divulgacao"/><noscript><img width="330" height="180" src="http://catracalivre.com.br/wp-content/uploads/2014/03/dali_divulgacao-330x180.jpg" class="attachment-grid4-medio wp-post-image" alt="dali_divulgacao"/></noscript></a>
                        <div class="post-content">
                            <h3 class="titulo-subeditoria clearfix">
                                <a href="http://catracalivre.com.br/geral/editoria/agenda/saiba-antes/">Saiba Antes</a>
                            </h3>
                            <h1><a href="http://catracalivre.com.br/geral/saiba-antes/indicacao/em-maio-exposicao-do-dali-chega-ao-brasil/" title="Em maio, exposi&ccedil;&atilde;o do Dal&iacute; chega ao Brasil ">Em maio, exposição do Dalí chega ao Brasil </a></h1>
                        </div>
                    </article>

                </div>
                <ul class="numeric-nav hl-num-nav"></ul>
                <nav class="hl-nav next"></nav>
                <nav class="hl-nav prev"></nav>
            </div>

        </section>
    <!-- --------------------------------- -->



        <div class="row">
            <section id="main-section" class="panel-group col-md-11 col-md-offset-1">

                <div class="panel panel-default hl-carrousel" ng-show="viewBy === 'space' && viewMode === 'grid'" on-last-repeat  ng-repeat="space in searchResult" ng-show="!filters.spaces || (filters.spaces && space.isSelected())">

                    <div class='hl-ref'></div>

                    <div class="panel-heading clearfix">
                        <h4 class="alignleft panel-title">
                            <a class="icon icon_pin" href="#" data-toggle="modal" data-target="#map-modal"></a> <a href="{{spaceUrl(space.id)}}">{{space.name}}</a>
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
                                    <img src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
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

                <div class="panel panel-default" ng-if="viewBy === 'space' && viewMode === 'list'" ng-repeat="space in searchResult" ng-show="!filters.spaces || (filters.spaces && space.isSelected())">
                    <div class="panel-heading clearfix">
                        <h4 class="alignleft panel-title">
                            <a class="icon icon_pin" href="#" data-toggle="modal" data-target="#map-modal"></a> <a href="{{spaceUrl(space.id)}}">{{space.name}}</a>
                        </h4>
                        <a class="alignright" data-toggle="collapse" data-parent="#main-section" href="#space-{{space.id}}">
                            <span class="icon arrow_carrot-down_alt2"></span>
                        </a>
                    </div>
                    <div id="space-{{space.id}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <article class="event clearfix event-list" ng-repeat="event in space.events">
                                    <img src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
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

            view by:
        <button id="time-view" type="button" class="btn btn-secondary" ng-class='{"active": viewBy === "space"}' ng-click="viewBy = 'space'">space ({{searchResult.length}} espaços)</button>
        <button id="time-view" type="button" class="btn btn-secondary" ng-class='{"active": viewBy === "time"}' ng-click="viewBy = 'time'">time ({{searchResultEventsByName.length}} eventos)</button>
        <button id="time-view" type="button" class="btn btn-secondary" ng-class='{"active": viewBy === "name"}' ng-click="viewBy = 'name'">name ({{searchResultEventsByTime.length}} eventos)</button>

    </div>
    <!-- .container-fluid -->
</div>
<?php get_footer(); ?>