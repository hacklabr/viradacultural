<?php get_header(); ?>
<nav id="programacao-navbar" class="navbar navbar-fixed-top">
	<div class="container-fluid">
		<div class="col-md-offset-1">
			<h1 class="">Programação</h1>
			<div id="view-btn-group" class="btn-group">
				<button type="button" class="btn btn-secondary active"><span class="icon icon_grid-2x2"></span></button>
				<button type="button" class="btn btn-secondary"><span class="icon icon_menu-square_alt"></span></button>
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
				<button type="button" class="btn btn-primary"><span class="icon icon_pin"></span> Filtrar Locais</button>
			</div>
	        <div class="programacao-navbar-item">
				<button type="button" class="btn btn-primary"><span class="icon icon_download"></span> Baixar PDF</button>
			</div>						
			
		</div>
	</div>
</nav>
<div class="container-fluid">
	<div class="row">
		<section id="main-section" class="panel-group col-md-11 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h4 class="alignleft panel-title">
						<a class="icon icon_pin" href="#"></a> Espaço 1
					</h4>
					<a class="alignright" data-toggle="collapse" data-parent="#main-section" href="#collapseOne">
						<span class="icon arrow_carrot-down_alt"></span>
					</a>
				</div>
				<div id="collapseOne" class="panel-collapse collapse">
					<div class="program-nav program-nav-left"><span class="icon arrow_carrot-left"></span></div>
					<div class="program-nav program-nav-right"><span class="icon arrow_carrot-right"></span></div>
					<div class="panel-body">
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
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
						<a class="icon icon_pin" href="#"></a> Espaço 2
					</h4>
					<a class="alignright" data-toggle="collapse" data-parent="#main-section" href="#collapseTwo">
						<span class="icon arrow_carrot-down_alt"></span>
					</a>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse">
					<div class="panel-body">
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
								<h1><a href="#">Título do evento que pode ser bem comprido e cair em quatro linhas</a></h1>
								<footer class="clearfix">
									<span class="alignleft"><span class="icon icon_clock"></span> <time>00h00</time></span>
									<a class="alignright icon icon_star" href="#"></a>
								</footer>
							</div>
						</article>
						<article class="event">
							<img src="http://localhost/viradacultural/wp-content/uploads/2014/03/Virada-Cultural-2013_racionais-foto_sylvia_masini-18-320x210.jpg">
							<div class="event-content">
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
