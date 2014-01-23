<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ie" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

	<head>
		<meta charset="utf-8">
		<meta name="description" content="Online tenis prvenstvo" />
		<title>TK Vinodol Online Champions League</title>
		<meta name="robots" content="index, follow">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		{{ HTML::style('css/frenzy-orange.css'); }}
		{{ HTML::style('css/tenis.css?v=3.2'); }}
		{{ HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/ui-lightness/jquery-ui.css'); }}

		<link rel="shortcut icon" href="{{ URL::base() }}/img/ico/favicon.ico">
		
		<!-- JS Libs -->
		
		{{ HTML::script('js/libs/jquery.js'); }}
		{{ HTML::script('js/libs/modernizr.js'); }}
		{{ HTML::script('js/libs/selectivizr-min.js'); }}

		<script type="text/javascript">
			var baseURL = "{{ URL::base() }}";
		</script>
	</head>
	<body>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=129280210602890";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div id="bg"><img src="{{ URL::base() }}/img/assets/bg.jpg" alt="background"></div>

		<!--///////////////////////////// Header Area //////////////////////////////////-->

		<!-- Header Start -->
		<header class="header">
			<div class="container visible-desktop">
				<div class="row">
					<div class="span12" role="navigation" id="topnav">
						<!-- top nav -->
						
					</div>
				</div>
			</div>
			<div id="nav" class="container">
				<div class="row">
				<!-- Logo & Navigation -->
					<div class="span12" role="navigation" id="mainnav">
					<!-- Site Logo -->
					<h1 id="logo" alt="Vinodol Open" class="visible-desktop"><a href="{{ URL::base() }}">Vinodol Open</a></h1>					
					<nav id="main-navigation" class="visible-desktop">
						<ul class="first-level">
							<li><a href="{{ URL::base() }}">Pocetna</a></li>
							<li><a class="uizradi" href="{{ URL::to('results/head') }}">Head to Head</a></li>

							<li><a href="#">Prijava rezultata <span class="icon awe-chevron-down"></span></a>
								<ul class="second-level">
									<li><a href="{{ URL::to('results/new') }}">Novi rezultat</a></li>
									<li><a class="uizradi" href="{{ URL::to('results/edit') }}">Ispravak rezultata</a></li>
								</ul>
							</li>
							<li><a class="uizradi" href="{{ URL::to('results/show') }}">Svi rezultati</a></li>
							<li><a href="{{ URL::to('users') }}">Igrači</a></li>
							<li><a href="#">Turniri <span class="icon awe-chevron-down"></span></a>
								<ul class="second-level">
									<li><a href="{{ URL::to('tour/sign_in') }}">Prijavi se na turnir</a></li>
									<li><a class="uizradi" href="{{ URL::to('tour/draw') }}">Rezultati turnira</a></li>
									<li><a class="uizradi" href="{{ URL::to('tour/result') }}">Upisi rezultat</a></li>
									<?php $user = Auth::user();
									if(($user) && (($user->id == 4) || ($user->id == 6))){ ?>
										<li><a class="uizradi" href="{{ URL::to('tour/admin') }}">Admin</a></li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</nav>

					<nav id="secondary-navigation" class="visible-desktop">
						<div class="social-media">
							<ul>
								<li><a href="https://www.facebook.com/groups/207165545981512/"><span class="awe-facebook"></span></a></li>
							</ul>
						</div>
					</nav>
					<!-- Navigation End -->
					</div>
				</div>
			</div>
		</header>
		<!-- Header End -->

		<!--///////////////////////////// Slider Area //////////////////////////////////-->

		<?php $notifications = Session::get('notifications');	?>

		@if ( $notifications )
			<p style="text-align:center;font-weight:bold"> 
			   	@foreach ($notifications as $notification)
				    {{ $notification }} <br>
				@endforeach
			</p>
		@endif

		@yield('ljestvica')

		<!--///////////////////////////// End Slider Area //////////////////////////////////-->

		<!--///////////////////////////// Main Content Area //////////////////////////////////-->

		<!-- Main Content Wrapper Start -->
		<div class="container" role="main">
			

			<section id="main-content" class="row">
							
				<div id="content" class="span8">
				  
					<div class="post-single" id="post">
						<div class="content-outer">
							<div class="content-inner">
								@yield('maincontent')								
							</div>

							<!-- content inner -->
						</div>
						<!-- content outer -->
					</div>
				    
				</div>

				<!-- Sidebar Right -->
				<div id="right-sidebar" class="span4">
					@yield('login')
				</div>
				<!-- Sidebar End -->
			</section>
		</div>
		<!-- Main Content Wrapper End -->

		<!--///////////////////////////// Footer Area //////////////////////////////////-->

		<!-- Footer Start -->
		<footer class="footer">
			
			<div class="container" role="navigation">
				<section class="row">
					<div class="footer-menu">
						<!--<ul>
							<li><a href="#" title="link">About Us</a></li>
							<li><a href="#" title="link">Contact Us</a></li>
							<li><a href="#" title="link">Term of Services</a></li>
						</ul>-->
					</div>
					
					<div class="copyright">
						<p><a href="http://webcode.com.hr" title="webcode.com.hr">Webcode</a> - izrada web stranica.
						</p>
					</div>
				</section>
			</div>
		</footer>
		<!-- Footer End -->

 
<!-- Modal -->
<div id="signInModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="signInModalLabel" aria-hidden="true">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="signInModalLabel">Sign In</h3>
    </div>
	<div class="modal-body">
		<form method="post" action="#" name="login_form">
			<p><input type="text" class="span3" name="eid" id="email" placeholder="Email"></p>
			<p><input type="password" class="span3" name="passwd" placeholder="Password"></p>
			<p><button type="submit" class="btn btn-primary">Sign in</button>
				<a href="#">Forgot Password?</a>
			</p>
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>

		{{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js'); }}	
		{{ HTML::script('js/bootstrap/bootstrap.js'); }}	
		{{ HTML::script('js/plugins/slides.jquery.js'); }}	
		{{ HTML::script('js/plugins/camera.min.js'); }}	
		{{ HTML::script('js/custom.js?v=3.4'); }}	

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-41181153-1', 'vinodolopen.com');
		  ga('send', 'pageview');
			
			var BASE = "<?php echo URL::base(); ?>";
		
		</script>
	</body>
</html>