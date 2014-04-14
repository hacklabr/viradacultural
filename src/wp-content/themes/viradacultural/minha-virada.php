<!-- .container-fluid -->

<?php 

$object = get_query_var('virada_object'); 

if ($object) {
    $userinfo = minhaVirada::loadJSON($object);
}

?>

<?php get_header(); ?>
<div ng-controller="espaco">
    <div class="container-fluid container-menu-large">
        <section id="main-section" class="row">
            <article id="space-00" class="space-single">
                <header>
                    <h1><?php echo isset($userinfo->name) ? $userinfo->name : 'Minha Virada'; ?></h1>
                </header>
                <img class="center-block" ng-src="{{conf.templateURL}}/img/virada-icon-2x.png">
                
                <?php if (isset($userinfo->picture)): ?>
                    <img src="<?php echo $userinfo->picture; ?> " />
                <?php endif; ?>
                
                <?php if (isset($userinfo->events) && is_array($userinfo->events) && sizeof($userinfo->events) > 0): ?>
                
                <?php var_dump($userinfo->events); ?>
                
                <div class="timeline clearfix">
                    <div class="event-group" ng-repeat="event in spaceEvents">
                        <div class="timeline-time">{{event.startsAt}}</div>
                        <article class="event clearfix event-grid">
                                <img ng-src="{{conf.baseURL}}/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg"/>
                                <div class="event-content clearfix">                                    
                                    <h1><a href="{{eventUrl(event.id)}}">{{event.name}}</a></h1>
                                    <a class="icon favorite favorite-event-{{event.id}}" href="#" ng-click="favorite(event.id)"><!--qdo selecionado adicionar classe 'active'--></a>
                                </div>
                            </article>
                    </div>
                </div>
                <!-- .timeline -->
                
                <?php else: // usuario nao logado ou usuario q ainda não tem nenhum evento ?>
                    
                    Instruções de como usar...

                <?php endif; ?>
                
                
                
            </article>
            <!-- .event-single -->
        </section>
        <!-- #main-section -->
        <?php get_footer(); ?>
    </div>
    <!-- .container-fluid -->
</div>
<?php html::part('countdown'); ?>
