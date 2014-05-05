<article id="post-<?php echo $item->id; ?>" data-date="<?php echo $item->date;?>" class="<?php echo 'type-'.$item->type;?> clearfix grid-post post-redes col-lg-3 col-md-6 col-sm-4 col-xs-12 bottom left right js-redes-adjust-height"
    <?php if ($ajaxhide) echo 'style="display:none"'; ?> >
<?php if ($item->type == 'twitter_cpt'): ?>
    <div class="post-content">
        <div class="post-type-icon"><span class="icon social_twitter"></span></div>
        <header>
            <p>
            <a href="<?php echo 'http://twitter.com/', $item->author_username; ?>">@<?php echo $item->author_username; ?></a><br>
            <time class="post-time" datetime="<?php echo $item->dateFormatted; ?>" pubdate><?php echo $item->dateTimeFormatted; ?></time>
            </p>
        </header>
        <?php echo $item->content; ?>

    </div>
<?php else: ?>
    <div class="post-img">
        <div class="post-img-cover visible-lg"></div>
        <?php echo $item->content; ?>
    </div>
        <div class="post-type-icon"><span class="icon social_instagram"></span></div>
        <footer>
            <p>
                <a href="<?php echo 'http://instagram.com/', $item->author_username; ?>"><?php echo $item->author_username; ?></a><br>
                <time class="post-time" datetime="<?php echo $item->dateFormatted; ?>" pubdate><?php echo $item->dateTimeFormatted; ?></time>
            </p>
        </footer>
<?php endif; ?>

</article>
<!-- .post -->



