@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Ispravi rezultat</h1>
		
		<div class="separator"></div>
	</div>

	<?php $errors = Session::get('errors');	?>

	@if ( $errors )
	   	@foreach ($errors as $error)
		    {{ $error }} <br>
		@endforeach
	@endif		

 		@foreach ($rezultati as $rezultat)
 			<div class='row-fluid'>
 				<div class='span7'>
					<table class="upisrezultata">	
						<tr>
							<td><img class="img-circle" src="http://graph.facebook.com/{{ $rezultat->user->fb_id }}/picture?width=60&height=60&r"></td>
							<td>{{ $rezultat->user->name }}</td>
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
						<tr>
							<td><img class="img-circle" src="http://graph.facebook.com/{{ $rezultat->suparnik->fb_id }}/picture?width=60&height=60&r"></td>
							<td>{{ $rezultat->suparnik->name }}</td>
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
				<div class='span5 podaci'>
					<table class="upisrezultata">
						<tr>
							<td>Teren:</td>
							<td>{{ $rezultat->teren->naziv }}</td>
						</tr>
						<tr>
							<td>Podloga:</td>
							<td>{{ $rezultat->podloga->naziv }}</td>
						</tr>
						<tr>
							<td>Datum:</td>
							<td>{{ $rezultat->datum }}</td>
						</tr>	
					</table>
				</div>
			</div>
			<div class='edit'>
				<button type="button" class='btn btn-warning'>{{HTML::link_to_action('results@edit_single', 'Ispravi rezultat', array($rezultat->id))}}
				</button>
				<button type="button" class='btn btn-warning'>{{HTML::link_to_action('results@destroy', 'Izbrisi rezultat', array($rezultat->id))}}</button>
			</div>
		</br>
		<hr>
		@endforeach
@endsection