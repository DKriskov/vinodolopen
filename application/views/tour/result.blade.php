@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Upisi rezultat turnira <?php 
		if(!empty($tour_rez)){
			echo $tour_rez->start_date.'</h1>'; 
		} else {
			echo '</h1></br><h4>nema meca za upisat</h4>';
		}
		?>	
		<div class="separator"></div>
	</div>
	<?php 
	$set = array(-1=>'',0=>0, 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7);
	$set_class = array('class' => 'num_select');
	if(!empty($tour_rez)){
	?>
	{{ Form::open('tour/result','POST') }}
		<table class="upisrezultata">
			<tr>
				<th></th>
				<th>1</th>
				<th>2</th>
				<th>3</th>
			</tr>
			<tr>
				{{ Form::hidden('rez_id',$tour_rez->id)}}
				<td>{{ $tour_rez->player1->name }}</td>
				{{ Form::hidden('p1_id',$tour_rez->p1_id)}}
				{{ Form::hidden('stage',$tour_rez->stage)}}
				<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
			</tr>
			<tr>
				<td>{{ $tour_rez->player2->name; }}</td>
				{{ Form::hidden('p2_id',$tour_rez->p2_id)}}
				<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
				<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
			</tr>
		</table>
	{{ Form::submit('Dodaj rezultat', array('class' => 'btn btn-warning')); }}		
	{{ Form::close() }}
	<?php 
	}
	?>
@endsection