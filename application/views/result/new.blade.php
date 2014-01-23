@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Novi rezultat</h1>
		
		<div class="separator"></div>
	</div>

	<?php $errors = Session::get('errors');	?>

	@if ( $errors )
	   	@foreach ($errors as $error)
		   <p style="color:red">{{ $error }}</p>
		@endforeach
	@endif

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
	{{ Form::open('results/new') }}
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
				<td>{{ $me->name; }}</td>
				<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
			</tr>
			<tr>
				<td>{{ Form::select('suparnik', $suparnici,'',array('class' => 'select_igrac' )) }}</td>
				<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
			</tr>
		</table>
		<table class="upisrezultata">
			<tr>
				<td>Teren:</td>
				<td>
					<select name="teren">
						@foreach ($tereni as $teren)
		                  <option value='{{ $teren->id }}'>{{ $teren->naziv }}</option>
		                @endforeach
	            	</select>
				</td>
			</tr>
			<tr>
				<td>Podloga:</td>
				<td>
					<select name="podloga">
						@foreach ($podloge as $podloga)
		                  <option value='{{ $podloga->id }}'>{{ $podloga->naziv }}</option>
		                @endforeach
	            	</select>
				</td>
			</tr>
			<tr>
				<td>Datum:</td>
				<td>{{ Form::text('datum',date("d.m.Y.")) }}</td>
			</tr>
		</table>
		<br>
		{{ Form::submit('Dodaj rezultat'); }}		
	{{ Form::close() }}
@endsection