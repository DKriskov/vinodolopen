@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Turnir</h1>
		
		<div class="separator"></div>
	</div>

	<?php $messages = Session::get('messages');	?>

	@if ( $messages )
	   	@foreach ($messages as $message)
		   <p style="color:orange">{{ $message }}</p>
		@endforeach
	@endif

	<?php 
		 
	if(!empty($next_tour_date)){
		
		echo '<h4>Prijave za turnir: '.$next_tour_date.'</h4>';
		echo '<p>Potrebno je prijavit minimalno 8 igraca</p>';
		echo '<p>Prijavljeno je '.$players_num.' igrača</p>';
	
		$user = Auth::user();

		echo Form::open('tour/signed', 'POST'); 
		$prijevljeni = array();
		if(!empty($signed)){
			$j = 1;
			foreach ($signed as $sign) {
				$prijavljeni[]=$sign->user_id;
				$j++;
			}
		}
		if (($user) && (!empty($signed)) && !empty($next_tour_date) && ($j < 16) && (!in_array($user->id, $prijavljeni))){
				echo'<p>'.$user->name.'</p>';
				echo Form::hidden('user',$user->id);
				echo Form::submit('Prijavi se', array('class' => 'btn btn-warning'));  
		} elseif (($user) && empty($signed)) {
			echo'<p>'.$user->name.'</p>';
			echo Form::hidden('user',$user->id);
			echo Form::submit('Prijavi se', array('class' => 'btn btn-warning'));
		}
		echo Form::close();
		if (!$user) { echo '<p>Za prijavu ili odjavu s turnira potrebno je ulogirati se</p>'; }	
		if (($user) && (!empty($signed)) && (in_array($user->id, $prijavljeni))){ 
			echo '<p>nalaziš se u turniru</p>';
			echo Form::open('tour/signout', 'POST');
			echo Form::hidden('user_id',$user->id);
			echo Form::hidden('start_date',$next_tour_date);
			echo Form::submit('odjavi se', array('class' => 'btn btn-warning'));
			echo Form::close();
		}

		if($signed){
			echo '<div>';
			echo '<p>Do sada su prijavljeni: </p>';
			$i=1;
			$broj_nositelja = 16 - $players_num;
			if ($players_num == 8){
				$broj_nositelja = 4;
			}
			if ($players_num == 16){
				$broj_nositelja = 8;
			}
			foreach ($signed as $sign) { 
				if($i<=$broj_nositelja){
					echo '<p>'.$sign->name.' ('.$i.')</p>';
				} else {
					echo '<p>'.$sign->name.'</p>';
				}
				$i++;
			}
			$more_players = 8-($i-1);
			if($i<8){
				echo '<p>Potrebno je još najmanje '.$more_players.' igrača za početak turnira</p>';
			}
			echo '</div><hr>';
		} else { echo '<h4>nema prijavljenih igrača do sada</h4>';}
	} else {
		echo '<h4>Još nije određen datum novog turnira</h4>';
	}?>

@endsection
