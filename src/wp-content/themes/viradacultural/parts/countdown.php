<div id="countdown" class="col-md-2">
	<div>
		Faltam
	</div>
	<div class="circle">44</div>
	<div>dias</div>
	<div class="circle">02</div>
	<div>horas</div>
	<div class="circle">30</div>
	<div>min</div>
	<footer>
		<time>
			<div>17-18</div>
			<div>maio</div>
			<div>2014</div>
		</time>
		<div class="rede-sociais">
			
            <?php $redes = get_theme_option('social_networks'); $redesbuttons = array('facebook', 'twitter', 'googleplus'); ?>
            
            <?php foreach ($redesbuttons as $button): ?>
                <?php if (isset($redes[$button]) && $redes[$button]): ?>
                    <a class="icon social_<?php echo $button; ?>_circle" href="<?php echo $redes[$button]; ?>" target="_blank"></a>
                <?php endif; ?>
            <?php endforeach; ?>
            

		</div>
	</footer>
</div>
<!-- #countdown -->
