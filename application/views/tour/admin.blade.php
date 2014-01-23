@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Admin</h1>
		
		<div class="separator"></div>
	<?php 
	$user = Auth::user();
	
	if(($user) && ($players_num >= 8) && ($start_tour != 0) && (($user->id == 4) || ($user->id == 6))){
		echo '<p>'.HTML::link_to_action('tour@start_tour', 'Startaj turnir', array(), array('class'=>'btn btn-warning')).'</p>';
	}
	if(($user) && ($players_num > 0) && (($user->id == 4) || ($user->id == 6))){
		echo '<p>'.HTML::link_to_action('tour@delete_tour', 'Izbrisi sve prijavljene/startaj novi turnir', array(), array('class'=>'btn btn-warning')).'</p>';
	}
	if(($user) && (($user->id == 4) || ($user->id == 6))){
		echo '<div id="new_tour">';
				echo Form::open('tour/setTour_date', 'POST');
				echo Form::label('next_tour_date','Postavi datum sljedeceg turnira');
				echo Form::text('next_tour_date','',array('placeholder' => 'yyyy-mm-dd'));
				echo '<p>'.Form::submit('Postavi datum novog turnira', array('class' => 'btn btn-warning')).'</p>';
				echo Form::close();
			echo '</div>';
	}
	if(empty($results)){
		echo '</h1></br><h4>nema meca za upisat</h4>';
	}
	?>	
		<div class="separator"></div>
	</div>
	<div class='row-fluid prijavi'>
		<h3>Prijavi igraca</h3>
	<?php 
		foreach ($not_signed_in as $not_signed) {
			if (is_null($not_signed->prijavljeni) ) {
				echo Form::open('tour/signed', 'POST');
				echo "<div class='span6'>";
				echo Form::label('user', $not_signed->name);
				echo "</div>";
				echo "<div class='span6 prijavi'>";
				echo Form::hidden('user',$not_signed->id);
				echo Form::submit('Prijavi igraca', array('class' => 'btn btn-warning'));
				echo "</div>";
				echo Form::close();	
			}
		}
	?>
	</div>
	<div class="separator"></div>
	<div>
		<h3>Upisi rezultate turnira</h3>
		<?php 
		$set = array(-1=>'',0=>0, 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7);
		$set_class = array('class' => 'num_select');
		if(!empty($results)){
			foreach ($results as $result){
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
							{{ Form::hidden('rez_id',$result->id)}}
							<td>{{ $result->player1->name }}</td>
							{{ Form::hidden('p1_id',$result->p1_id)}}
							{{ Form::hidden('stage',$result->stage)}}
							<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
							<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
							<td>{{ Form::select('igrac1_set[]', $set,'',$set_class) }}</td>
						</tr>
						<tr>
							<td>{{ $result->player2->name; }}</td>
							{{ Form::hidden('p2_id',$result->p2_id)}}
							<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
							<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
							<td>{{ Form::select('igrac2_set[]', $set,'',$set_class) }}</td>
						</tr>
					</table>
				{{ Form::submit('Dodaj rezultat', array('class' => 'btn btn-warning')); }}		
				{{ Form::close() }}
		<?php
			} 
		}
		?>
	</div>
@endsection