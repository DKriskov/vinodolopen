@section('ljestvica')
	<!-- Main Slider Start -->
	<div class="container hidden-phone" id="slideshow">
		<section id="slider" class="row">
			<div class="span8">
				<!-- Begin Slider -->
				<div id="slidejs">
					<!-- Slide items -->
					<div class="slides-container" >	
						@foreach ($rezultati as $rezultat)

						
						    <div class="slide-outer span8">
								<div class="slide-inner" style="position:relative">

									
									<div class="mecinfo">
										<span class="title item-first">Datum:</span> <?php echo date('d.m.Y.',strtotime($rezultat->datum))?>
										<span class="title">Teren:</span> {{ $rezultat->teren->naziv }}
										<span class="title item-last">Podloga:</span> {{ $rezultat->podloga->naziv }}
									</div>

									<table class="scoreboard">										
										<tr class="up">
											<td class="igrac">
												<img src="http://graph.facebook.com/{{ $rezultat->user->fb_id }}/picture?width=200&height=200&r">
												<div class="ime">{{ $rezultat->user->name }}</div>
											</td>
											<td class="set">{{ $rezultat->u_final }}</td>

											@if ( $rezultat->u1 != -1 )
											    <td class="game">{{ $rezultat->u1 }}</td>
											@endif
											@if ( $rezultat->u2 != -1 )
											    <td class="game">{{ $rezultat->u2 }}</td>
											@endif
											@if ( $rezultat->u3 != -1 )
											    <td class="game">{{ $rezultat->u3 }}</td>
											@endif
											@if ( $rezultat->u4 != -1 )
											    <td class="game">{{ $rezultat->u4 }}</td>
											@endif
											@if ( $rezultat->u5 != -1 )
											    <td class="game">{{ $rezultat->u5 }}</td>
											@endif

										</tr>
										<tr class="down">
											<td class="igrac">
												<img src="http://graph.facebook.com/{{ $rezultat->suparnik->fb_id }}/picture?width=200&height=200&r">
												<div class="ime">{{ $rezultat->suparnik->name }}</div>
											</td>
											<td class="set">{{ $rezultat->s_final }}</td>
											
											@if ( $rezultat->s1 != -1 )
											    <td class="game">{{ $rezultat->s1 }}</td>
											@endif
											@if ( $rezultat->s2 != -1 )
											    <td class="game">{{ $rezultat->s2 }}</td>
											@endif
											@if ( $rezultat->s3 != -1 )
											    <td class="game">{{ $rezultat->s3 }}</td>
											@endif
											@if ( $rezultat->s4 != -1 )
											    <td class="game">{{ $rezultat->s4 }}</td>
											@endif
											@if ( $rezultat->s5 != -1 )
											    <td class="game">{{ $rezultat->s5 }}</td>
											@endif

										</tr>
									</table>									
									
								</div>
							
								<div class="slide-caption">
									<div class="caption-inner">
										<div class="caption-after"></div>
										<div class="caption">
											Posljednji mecevi
											<div class="caption-below" style="position:relative">
												{{ $rezultat->user->name }} Vs. {{ $rezultat->suparnik->name }}
												
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach

						
											
						
					</div>

				</div>
				<!-- End Slider -->
			</div>
			<!-- End Span8 -->

			<!-- Begin Span4 Carousel Slider --> 
			<div class="span4 carousel-widget visible-desktop" id="slider-widget">
				<div class="widget-content carousel slide" id="ljestvica">
					<!-- Begin Carousel Inner -->
					<div class="carousel-inner">	
						<!-- Begin Slide Section / Carousel Item -->
						<div class="widget-header">
							<h4 style="margin:0 0 10px" class="widget-heading">Top 6: &nbsp; <?php echo date("m") ?>. Mjesec</h4>
						</div>
						<div class="ljestvica-table" data-heading="Top 15: &nbsp; <?php echo date("m") ?>. Mjesec">
							<table class="ljestvica">
								<tr class="heading">
									<th class="rank">Rank</th>
									<th class="player">Tenisač</th>
									<th class="matches">Mečeva</th>
									<th class="game">Game</th>
									<th class="points">Bodovi</th>
								</tr>
								<?php $i=1; ?>
								@foreach ($ljestvica_mj as $ljestvica)
										<tr class="rank-{{ $i }}">
											<td class="rank">{{ $i }}</td>
											<td class="player">{{ $ljestvica->user->name }}</td>
											<td class="matches">{{ $ljestvica->meceva }}</td>
											<td class="game">{{ $ljestvica->game_razlika }}</td>
											<td class="points">{{ $ljestvica->bodova }}</td>
										</tr>
								<?php $i++; ?>
								@endforeach									
							</table>
						</div>
						<!-- End Slide Section / Carousel Item -->
						<!-- =================================================================== -->						
						<!-- Begin Slide Section / Carousel Item -->
						<div class="widget-header">
							<h4 style="margin:0 0 10px" class="widget-heading">Top 6: &nbsp; Sezona 2013</h4>
						</div>
						<div class="ljestvica-table" data-heading="Top 15: &nbsp;Sezona 2013">
							<table class="ljestvica">
								<tr class="heading">
									<th class="rank">Rank</th>
									<th class="player">Tenisač</th>
									<th class="matches">Mečeva</th>
									<th class="game">Game</th>
									<th class="points">Bodovi</th>
								</tr>
								<?php $i=1; ?>
								@foreach ($ljestvica_god as $ljestvica)
									
										<tr class="rank-{{ $i }}">
											<td class="rank">{{ $i }}</td>
											<td class="player">{{ $ljestvica->user->name }}</td>
											<td class="matches">{{ $ljestvica->meceva }}</td>
											<td class="game">{{ $ljestvica->game_razlika }}</td>
											<td class="points">{{ $ljestvica->bodova }}</td>
										</tr>
										<?php $i++; ?>
								@endforeach							
													
							</table>
						</div>
						<!-- End Slide Section / Carousel Item -->
						<!-- =================================================================== -->
						
					
						
					</div>
					<!-- End Carousel Inner -->
				
				</div>
			</div>
			<!-- End Span 4 Carousel Slider -->
		</section>
	</div>
	<!-- Main Slider End -->
@endsection