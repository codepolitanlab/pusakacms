<!-- HEADER -->
<header style="background:#30b695 url({{ func.get_file_url file='cover_4.jpg' }}) no-repeat center top;">

	<!-- NAV -->
	<nav class="navbar navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="collapse navbar-collapse">

				<ul class="nav navbar-nav navbar-right">
					<li><a class="scrollable" href="{{ func.site_url }}#about">About</a></li>
					<li><a class="scrollable" href="{{ func.site_url }}#works">Works</a></li>
					<li><a class="scrollable" href="{{ func.site_url }}#contact">Contact</a></li>
					<li><a href="{{ func.site_url }}blog">Blog</a></li>
					<li><a href="#" class="icon-sosmed"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#" class="icon-sosmed"><i class="fa fa-twitter"></i></a></li>
				</ul>

			</div>
		</div>
	</nav>
	<!-- END: NAV -->


	<!-- INFO -->
	<div class="header-wrapper">
		<div class="container">
			<div class="header-inner">
				<div class="row">
					<div class="col-md-8">
						<h1 class="text-motto">Anda tidak akan pernah menemukan waktu untuk segalanya. Jika Anda menginginkan waktu, Anda harus menyediakannya.</h1>

						<a href="#" class="btn btn-lg btn-default">LIPSUM</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END: INFO -->

</header>
<!-- END: HEADER -->


<!-- ABOUT -->
<div class="about" id="about">
	<div class="container">

		<h1 class="text-center margin-lg-bottom">Hallo, I'm Devo</h1>

		<div class="text-center img-foto-about">
			{{ func.get_image_content file="si_devo.jpg" attr='class="img-circle" width="200"' }}
		</div>

		<p>
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut 
			laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation 
			ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor 
			in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero
		</p>

		<p>
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut 
			laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation 
			ullamcorper suscipit lobortis nisl uto
		</p>
	</div>
</div>
<!-- END: ABOUT -->



<!-- SKILL -->
<div class="skill-about-side"></div>
<div class="skill" id="skill">
	<div class="container">
		<h2 class="text-center title-skill">SKILL</h2>
		
		<div class="row">
			<div class="col-md-2">
				<span class="item-skill" style="background-image:url({{ func.get_file_url file='logo_ci.jpg' }})"></span>
				<div class="label-skill">CodeIgniter</div>
			</div>
			<div class="col-md-2">
				<span class="item-skill" style="background-image:url({{ func.get_file_url file='logo_css3.jpg' }})"></span>
				<div class="label-skill">CSS3</div>
			</div>
			<div class="col-md-2">
				<span class="item-skill" style="background-image:url({{ func.get_file_url file='logo_html5.jpg' }})"></span>
				<div class="label-skill">HTML5</div>
			</div>
			<div class="col-md-2">
				<span class="item-skill" style="background-image:url({{ func.get_file_url file='logo_jquery.jpg' }})"></span>
				<div class="label-skill">JQuery</div>
			</div>
			<div class="col-md-2">
				<span class="item-skill" style="background-image:url({{ func.get_file_url file='logo_wordpress.jpg' }})"></span>
				<div class="label-skill">Wordpress</div>
			</div>
			<div class="col-md-2">
				<span class="item-skill" style="background-image:url({{ func.get_file_url file='logo_pyrocms.jpg' }})"></span>
				<div class="label-skill">PyroCMS</div>
			</div>
		</div>
	</div>
</div>
<!-- END: SKILL -->



<!-- LOKASI -->
<div class="jakarta-wrapper">
	<div class="container">
		<div class="my-location-wrapper">
			<div class="im-here">
				<div class="media">
					<div class="pull-left">
						{{ func.get_image_content file="si_devo.jpg" attr='class="img-circle margin-lg-right" width="60"' }}
					</div>
					<div class="media-body">
						<div class="bubble-text">
							I'm in Jakarta!
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: LOKASI -->



<!-- WORK -->
<div class="project-wrapper padding-xl-bottom" id="works">
	<div class="container">
		<h1 class="text-center margin-xl-bottom">My Work</h1>
		
		<div class="row">
			<div class="col-md-4">
				<div class="margin-xl-bottom"><a href="http://www.codepolitan.com">{{ func.get_image_content file="img_codepolitan.jpg" attr='class="full-width"' }}</a></div>
			</div>
			<div class="col-md-4">
				<div class="margin-xl-bottom"><a href="http://www.nyankod.com/apps/flappynyan/">{{ func.get_image_content file="img_flappy.jpg" attr='class="full-width"' }}</a></div>
			</div>
			<div class="col-md-4">
				<div class="margin-xl-bottom"><a href="http://www.devository.com">{{ func.get_image_content file="img_devository.jpg" attr='class="full-width"' }}</a></div>
			</div>
			<div class="col-md-4">
				<div class="margin-xl-bottom"><a href="http://magz.nyankod.com">{{ func.get_image_content file="img_magz.jpg" attr='class="full-width"' }}</a></div>
			</div>
			<div class="col-md-4">
				<div class="margin-xl-bottom"><a href="http://www.sellanatasha.com">{{ func.get_image_content file="img_sella.jpg" attr='class="full-width"' }}</a></div>
			</div>
			
			<div class="col-md-4">
				<div class="margin-xl-bottom"><a href="http://www.kresnagaluh.com">{{ func.get_image_content file="img_kresnagaluh.jpg" attr='class="full-width"' }}</a></div>
			</div>
		</div>
	</div>
</div>
<!-- END: WORK -->



<!-- CONTACT -->
<div class="contact-wrapper" id="contact">
	<div class="container">
		<div class="row">
			<div class="col-md-5 goright">
				{{ func.get_image_content file="kujang_logo.png" }}
			</div>
			<div class="col-md-5">
				<h3 class="margin-md-bottom">Nyankod Office</h3>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
				<h4 class="margin-md-bottom"><i class="fa fa-envelope fa-fw"></i> youremail@mail.com</h4>
				<h4 class="margin-md-bottom"><i class="fa fa-phone fa-fw"></i> 021 - 73996 XXX</h4>
				<h4 class="margin-md-bottom"><i class="fa fa-facebook fa-fw"></i> Your Facebook</h4>
				<h4 class="margin-md-bottom"><i class="fa fa-twitter fa-fw"></i> @Twitter</h4>
			</div>
		</div>
	</div>
</div>
<!-- END: CONTACT -->