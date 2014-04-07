<?php get_header(); ?>
<div id="map-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon_close"></span></button>
				<h4 class="modal-title" id="myModalLabel">Mapa da Virada</h4>
			</div>
			<div class="modal-body clearfix">
				<div class="list-group">
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item active">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item active">Espaço1</a>
					<a href="#" class="list-group-item active">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
					<a href="#" class="list-group-item">Espaço1</a>
				</div>
				<div class="mapa">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary">Ver programação</button>
			</div>
		</div>
	</div>
</div>
<nav id="programacao-navbar" class="navbar navbar-fixed-top">
	<div class="container-fluid">
		<div class="col-md-offset-1">
			<h1>Programação</h1>
			<div id="view-btn-group" class="btn-group">
				<button id="grid-view" type="button" class="btn btn-secondary active"><span class="icon icon_grid-2x2"></span></button>
				<button id="list-view" type="button" class="btn btn-secondary"><span class="icon icon_menu-square_alt"></span></button>
			</div>
			<form id="programacao-search" class="programacao-navbar-item" role="search">
				<div class="input-group">
		            <input type="text" class="form-control" placeholder="Digite uma palavra-chave">
		            <span class="input-group-btn">
						<button class="btn btn-primary" type="button"><span class="icon icon_search"></span></button>
					</span>
		        </div>								
			</form>			
			<form class="clearfix programacao-navbar-item" role="time-filter">
				<div class="input-group bootstrap-timepicker">
		            <input id="timepicker-start" type="text" class="form-control timepicker-field" data-minute-step="5" data-show-meridian="false">
		            <span class="input-group-addon"><span class="icon icon_clock"></span></span>
		        </div>
		        <span class="navbar-left navbar-text"> às </span>
		        <div class="input-group bootstrap-timepicker">
		            <input id="timepicker-end" type="text" class="form-control timepicker-field" data-minute-step="5" data-show-meridian="false">
		            <span class="input-group-addon"><span class="icon icon_clock"></span></span>
		        </div>
	        </form>
	        <div class="programacao-navbar-item">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#map-modal"><span class="icon icon_pin"></span> Filtrar Locais</button>
			</div>
			<?php 
				$pdf = get_theme_option('pdf-programacao');
				if ($pdf):
			?>

	        <div class="programacao-navbar-item">
				<a href="<?php echo $pdf; ?>" role="button" class="btn btn-primary"><span class="icon icon_download"></span> Baixar PDF</a>
			</div>
			<?php endif; ?>					
			
		</div>
	</div>
</nav>
<div class="container-fluid">
	<div class="row">
		<section id="main-section" class="panel-group col-md-11 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h4 class="alignleft panel-title">
						<a class="icon icon_pin" href="#" data-toggle="modal" data-target="#map-modal"></a> <a href="#">Espaço 1</a>
					</h4>
					<a class="alignright" data-toggle="collapse" data-parent="#main-section" href="#collapseOne">
						<span class="icon arrow_carrot-down_alt2"></span>
					</a>
				</div>
				<div id="collapseOne" class="panel-collapse collapse">
					<div class="program-nav program-nav-left"><span class="icon arrow_carrot-left"></span></div>
					<div class="program-nav program-nav-right"><span class="icon arrow_carrot-right"></span></div>
					<div class="panel-body">
						<article class="event event-grid clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event event-grid clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event event-grid clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event event-grid clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event event-grid clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h4 class="alignleft panel-title">
						<a class="icon icon_pin" href="#" data-toggle="modal" data-target="#map-modal"></a> <a href="#">Espaço 2</a>
					</h4>
					<a class="alignright" data-toggle="collapse" data-parent="#main-section" href="#collapseTwo">
						<span class="icon arrow_carrot-down_alt2"></span>
					</a>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse">
					<div class="program-nav program-nav-left"><span class="icon arrow_carrot-left"></span></div>
					<div class="program-nav program-nav-right"><span class="icon arrow_carrot-right"></span></div>
					<div class="panel-body">
						<article class="event event-list clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event event-list clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event event-list clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event event-list clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event event-list clearfix">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content clearfix">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						
					</div>
				</div>
			</div>
		</section>
		<!-- #main-section -->
		<?php get_footer(); ?>
	</div>
	<!-- .row -->         
</div>
<!-- .container-fluid -->
