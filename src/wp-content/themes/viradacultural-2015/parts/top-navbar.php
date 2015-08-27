<nav id="site-navbar" class="virada-navbar navbar navbar-fixed-top hidden-xs hidden-sm">
    <div class="container-fluid <?php if (is_page_template('page-dez-anos.php')): ?>container-menu-minified<?php else: ?>container-menu-large<?php endif; ?>">
        <div class="row">
            <div class="col-md-4 col-lg-6">
                <h1>
                    <?php // títulos ?>
                    <?php if (is_front_page() || is_home()) { ?>
                        <?php if($url = get_theme_option('transparencia_url')): ?>
                            <a class="btn btn-primary btn-sm" href="<?php echo $url; ?>">Transparência</a>
                        <?php endif; ?>
                    <?php } else if ('noticias' == get_post_type() || is_post_type_archive('noticias')) { ?>
                        Notícias <!--<a class="btn btn-primary btn-sm" href="#">Arquivo de 2014</a> -->
                    <?php } else if (is_home()) { ?>
                        Blog
                    <?php } else if ('imprensa' == get_post_type() || is_post_type_archive('imprensa')) { ?>
                        Imprensa <a class="btn btn-primary btn-sm" href="<?php bloginfo('url'); ?>/credenciamento">Credenciamento</a>
                    <?php } else if (is_page_template('page-credenciamento-imprensa.php')) { ?>
                        Imprensa <a class="btn btn-primary btn-sm" href="<?php echo get_post_type_archive_link('imprensa'); ?>" title="Imprensa">Releases</a>
                    <?php } else if (is_category()) { ?>
                        <?php single_cat_title(); ?></h1>
                <?php } else if (is_search()) { ?>
                    Busca <small>Resultado da busca por <strong><?php echo get_search_query(); ?></strong></small>
                <?php } else if (is_page_template('page-nas-redes.php')) { ?>
                    Nas redes <small>#<?php echo get_theme_option('hashtag'); ?></small>
                <?php } else if (get_query_var('virada_tpl') && get_query_var('virada_tpl') == 'minha-virada') { ?>
                    Minha Virada
                <?php } else if (get_query_var('virada_tpl') && get_query_var('virada_tpl') == 'programacao-locais-single') { ?>
                    LOCAL
                <?php } else if (get_query_var('virada_tpl') && get_query_var('virada_tpl') == 'programacao-atracoes-single') { ?>
                    Atração
                <?php } else if (get_query_var('virada_tpl') && get_query_var('virada_tpl') == 'programacao-atracoes-single') { ?>
                    Atração
                <?php } else if (is_page_template('page-dez-anos.php')) { ?>
                    <?php the_title(); ?>
                <?php } else if (is_single()) { ?>
                    Blog
                <?php } else if (is_author()) { ?>
                    Blog - <?php wp_title(''); ?>
                <?php } ?>
                </h1>
            </div>
            <?php // share buttons ?>

            <div class="share-buttons col-md-4 col-lg-3">
                <ul>
                    <li class="facebook">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_share_url(); ?>" class="btn btn-default popup">
                            <span class="icon social_facebook"></span>
                            <span class="text">facebook</span>
                        </a>
                    </li>
                    <li class="twitter">
                        <a href="http://twitter.com/home?status=<?php the_share_url(); ?>" class="btn btn-default popup">
                            <span class="icon social_twitter"></span>
                            <span class="text">twitter</span>
                        </a>
                    </li>

                    <li class="googleplus">
                        <a href="https://plus.google.com/share?url=<?php the_share_url(); ?>" class="btn btn-default popup">
                            <span class="icon social_googleplus"></span>
                            <span class="text">google+</span>
                        </a>
                    </li>
                </ul>
            </div>


            <?php if (mostrar_programacao()): ?>
                <form id="pages-search" class="pages-navbar-item col-md-4 col-lg-3" role="search" action="<?php echo site_url(); ?>">
                    <div class="input-group">
                        <input type="text" name="s" id="search-term" class="form-control" placeholder="Busca" ng-model='searchText' ng-change='unaccentSearchText = unaccent(searchText)'>

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="icon icon_search"></span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a id="busca-programacao">Programação</a></li>
                                <li><a id="busca-site" >Site</a></li>
                            </ul>
                        </div><!-- /btn-group -->

                    </div>
                </form>
            <?php else: ?>
                <form id="pages-search" class="pages-navbar-item col-md-4 col-lg-3" role="search" action="<?php echo site_url(); ?>">
                    <div class="input-group">
                        <input type="text" name="s" class="form-control" placeholder="Busca" ng-model='searchText' ng-change='unaccentSearchText = unaccent(searchText)'>

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary">
                                <span class="icon icon_search" id="search-submit"></span>

                            </button>

                        </div><!-- /btn-group -->

                    </div>
                </form>
            <?php endif; ?>
        </div>


        <?php /*
          <div class="facebook">
          <div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-type="button_count"></div>
          </div>
          <div class="twitter">
          <a href="https://twitter.com/share" class="twitter-share-button" data-via="virada" data-lang="pt">Tweetar</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
          </div>
          <div class="g-plus">
          <!-- Place this tag where you want the share button to render. -->
          <div class="g-plus" data-action="share" data-annotation="bubble"></div>
          <!-- Place this tag after the last share tag. -->
          <script type="text/javascript">
          window.___gcfg = {lang: 'pt-BR'};

          (function() {
          var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
          po.src = 'https://apis.google.com/js/platform.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
          </script>
          </div>
         */ ?>

    </div>
</div>
</nav>


