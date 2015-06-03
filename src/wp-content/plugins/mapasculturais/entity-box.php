<?php
$price = '';
$same_price = true;
foreach ($entity->occurrences as $i => $occ) {
    if ($i > 0 && $price != $occ->price) {
        $same_price = false;
    }
    $price = $occ->price;
}
?>
<div class="servico event-container">
    <?php if ($entity->files->$image): ?>
        <figure class="event__image">
            <img src="<?php echo $entity->files->$image ?>" alt="<?php echo $entity->name ?>" />
        </figure>
    <?php endif; ?>
    <div class="event-data">
        <h1 class="event__title"><?php echo $entity->name ?> <span class="event__subtitle"><?php echo $entity->subTitle ?></span></h1>
        <?php foreach ($entity->occurrences as $occ): ?>
            <div class="event__occurrences">
                <div class="event__venue"><?php echo $occ->space->name ?></div>
                <div class="event__time"><?php echo $occ->description ?></div>
                <?php if (!$same_price && $occ->price): ?>
                    <div class="event__price">
                        <span class="fa-stack">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-usd fa-stack-1x fa-inverse"></i>
                        </span>
                        <?php echo $occ->price ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <span class="event__classification"><?php echo $entity->classificacaoEtaria ?></span>
        <?php if ($same_price): ?>
            <div class="event__price">
                <span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-usd fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo $price ? $price : __('Não informado', 'cultural') ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo $entity->singleUrl ?>" class="event__info"><?php _e('Mais informações', 'cultural'); ?></a>
    </div>
</div>
