
        <?php if (is_page() || is_single() || is_archive() || (is_home() && !is_front_page())) { ?>
        <nav id="programacao-navbar" class="navbar navbar-fixed-top">
            <div class="container-fluid">
                <div class="col-md-8 col-md-offset-2">

                    <?php if ('noticias' == get_post_type() || is_post_type_archive('noticias')) { ?>
                        <h1>Notícias</h1>
                    <?php } else if ('imprensa' == get_post_type() || is_post_type_archive('imprensa')) { ?>
                        <h1>Imprensa</h1>
                    <?php } else if (is_category()) { ?>
                        <h1><?php single_cat_title(); ?></h1>
                    <?php } else if (is_single() || is_home()) { ?>
                        <h1>Blog</h1>
                    <?php } ?>

                    <?php if (is_page() || is_single()) { ?>

                        <div class="share-buttons alignright">
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
                        </div><!-- .share-buttons -->
                    <?php } ?>
                </div>
            </div>
        </nav>
        <?php } ?>
        <?php if (is_search()) { ?>
        <nav id="programacao-navbar" class="navbar navbar-fixed-top">
            <div class="container-fluid">
                <div class="col-md-8 col-md-offset-2">
                    <h1>Resultados de busca para: <?php echo get_search_query(); ?></h1>
                </div>
            </div>
        </nav>
        <?php } ?>
