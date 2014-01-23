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
		<?php 
		$set = array(-1=>'',0=>0, 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7);
		$set_class = array('class' => 'num_select');
		
		foreach ($users as $user) {
			if ( $user->id != $me->id ) {
				$suparnici[$user->id] = $user->name;
			}					    
		}
		?>

		<p>Upiši rezultat u setovima:</p>
		{{ Form::open('results/update', 'PUT') }}
			<table class="upisrezultata">
				<tr>
					<th></th>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
				</tr>
				<tr>
					<td>{{ $rezultat->user->name }}</td>
						{{ Form::hidden('user',$rezultat->user->id) }}
						{{ Form::hidden('rezultat_id',$rezultat->id) }}
					<td>{{ Form::select('igrac1_set[]', $set,$rezultat->u1,$set_class) }}</td>
					<td>{{ Form::select('igrac1_set[]', $set,$rezultat->u2,$set_class) }}</td>
					<td>{{ Form::select('igrac1_set[]', $set,$rezultat->u3,$set_class) }}</td>
					<td>{{ Form::select('igrac1_set[]', $set,$rezultat->u4,$set_class) }}</td>
					<td>{{ Form::select('igrac1_set[]', $set,$rezultat->u5,$set_class) }}</td>
				</tr>
				<tr>
					<td>{{ $rezultat->suparnik->name }}</td>
						{{ Form::hidden('suparnik',$rezultat->suparnik->id) }}
					<td>{{ Form::select('igrac2_set[]', $set,$rezultat->s1,$set_class) }}</td>
					<td>{{ Form::select('igrac2_set[]', $set,$rezultat->s2,$set_class) }}</td>
					<td>{{ Form::select('igrac2_set[]', $set,$rezultat->s3,$set_class) }}</td>
					<td>{{ Form::select('igrac2_set[]', $set,$rezultat->s4,$set_class) }}</td>
					<td>{{ Form::select('igrac2_set[]', $set,$rezultat->s5,$set_class) }}</td>
				</tr>
			</table>
			<table class="upisrezultata">
				<tr>
					<td>Teren:</td>
					<td>
						<select name="teren">
							@foreach ($tereni as $teren)
							  <?php $selected_teren=''; ?>
							  @if($rezultat->teren_id == $teren->id)
							  	<?php $selected_teren = 'selected="selected"' ?>
							  @endif
			                  <option {{ $selected_teren }} value='{{ $teren->id }}'>{{ $teren->naziv }}</option>
			                @endforeach
		            	</select>
					</td>
				</tr>
				<tr>
					<td>Podloga:</td>
					<td>
						<select name="podloga">
							@foreach ($podloge as $podloga)
							  <?php $selected_podloga=''; ?>
							  @if($rezultat->podloga_id == $podloga->id)
							  	<?php $selected_podloga = 'selected="selected"' ?>
							  @endif
			                  <option {{ $selected_teren }} value='{{ $podloga->id }}'>{{ $podloga->naziv }}</option>
			                @endforeach
		            	</select>
					</td>
				</tr>
				<tr>
					<td>Datum:</td>
					<td>{{ Form::text('datum',$rezultat->datum) }}</td>
				</tr>
			</table>
			<br>
			{{ Form::submit('Dodaj rezultat'); }}		
		{{ Form::close() }}
	@endforeach
@endsection