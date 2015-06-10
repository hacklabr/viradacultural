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
<style type="text/css">
.servico {
    overflow: hidden;
}
.event-data {
    color: #333;
}
.event-data .event-occurrences {
    margin-bottom: 2rem;
}
.event-data .event-title {
    color: #000;
    margin: 0 0 2rem;
}
.event-data .event-venue span, .event-data .event-time span {
    color: #fb3f2a;
    font-weight: bold;
}
.event-data .event-classification {
    background-color: #27ae60;
    color: #fff;
    display: inline-block;
    float: left;
    font-size: 1.5rem;
    line-height: 2;
    padding: 0 1em;
}
.event-data .event-info {
    display: inline-block;
    float: right;
}

</style>
<div class="servico event-container">
    <div class="event-data">
        <h1 class="event-title"><?php echo $entity->name ?> <span class="event__subtitle"><?php echo $entity->subTitle ?></span></h1>
        <?php foreach ($entity->occurrences as $occ): ?>
            <div class="event-occurrences">
                <div class="event-venue"><span>Local:</span> <?php echo $occ->space->name ?></div>
                <div class="event-time"><span>Data: </span><?php echo $occ->description ?></div>
                <?php if (!$same_price && $occ->price): ?>
                    <div class="event-price">
                        <span class="fa-stack">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-usd fa-stack-1x fa-inverse"></i>
                        </span>
                        <?php echo $occ->price ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <span class="event-classification"><?php echo $entity->classificacaoEtaria ?></span>
        <?php if ($same_price): ?>
            <div class="event-price">
                <span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-usd fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo $price ? $price : __('Não informado', 'cultural') ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo $entity->singleUrl ?>" class="btn btn-primary event-info"><?php _e('Mais informações', 'cultural'); ?></a>
    </div>
</div>
