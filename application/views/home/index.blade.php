@layout('master')
@include('common.login')
@include('common.ljestvica')

@section('maincontent')
<?php /* 
	@foreach ($rezultati as $rezultat)
		<article>
			<div class="article-header">
				<h4 class="title" style="font-family: sans-serif, verdana;">{{ $rezultat->user->name }} Vs. {{ $rezultat->suparnik->name }}</h4>
				
				<div class="separator"></div>
			</div>
			
			<div class="article-content">
				<p>
					Dana <?php echo date('d.m.Y.',strtotime($rezultat->datum))?> na terenima {{ $rezultat->teren->naziv }} (podloga {{ $rezultat->podloga->naziv }})
					susreli su se <b>{{ $rezultat->user->name }}</b> i <b>{{ $rezultat->suparnik->name }}</b>!
				</p>
				<table class="scoreboard">										
					<tr class="up">
						<td class="igrac">
							<img src="http://graph.facebook.com/{{ $rezultat->user->fb_id }}/picture?width=200&height=200&r">
							<div class="ime" style="color:#fff">{{ $rezultat->user->name }}</div>
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
							<div class="ime" style="color:#fff">{{ $rezultat->suparnik->name }}</div>
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
				<p>
					Komentari?
				</p>
				<div class="fb-comments" data-href="http://vinodolopen.com/?rezultat={{ $rezultat->id }}" data-width="470" data-num-posts="2"></div>
			</div>
		</article>
	@endforeach
<?php */ ?>
	<article>
		<div class="article-header">
			<h1 class="title">Pravila</h1>
			
			<div class="separator"></div>
		</div>
		
		<div class="article-content">

			<p>Prvenstvo nema fiksan broj mečeva ali ima maksimalan broj bodova kojeg je moguće osvojiti.</p>
			<p>Svaki igrač donosi (ili uzima) najviše 3 boda svim ostalima (gledaju se posljednja 3 meča - svaki po jedan bod).</p>
			<p>Primjer sistema od četiri igrača: Federer, Fume, Muco i Hrvoje. Svi u ovom sistemu mogu najviše osvojiti 9 bodova, pa ako Fume svaki dan igra sa Federerom i pobjedi ga 10 puta za redom on na račun Federera osvaja 3 boda jer u zadnja 3 meča ima skor 3:0. Da bi osvojio maksimalan broj bodova, Fume mora 3 puta za redom pobjediti i Hrvoja i Mucu.</p>
			<p>Hrvoja je pobjedio bez problema međutim u zadnja 3 meča sa Mucom ima skor 1:2 pa ima 7 bodova (3 na Hrvoju, 3 na Federeru i 1 na Muci).</p>
			<p>Hrvoje ima 0 bodova jer nikoga nije pobjedio.</p>
			<p>Svaka sličnost sa stvarnim osobama sasvim je namjerna.</p>

		</div>
	</article>
@endsection

