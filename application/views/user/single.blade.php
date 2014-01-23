@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1><img class="img-circle" src="http://graph.facebook.com/{{$user->fb_id}}/picture?width=60&height=60&r"> {{$user->name}}</h1>
		
		<div class="separator"></div>
	</div>

	<h4>Ukupno pobjeda/poraza</h4>

	<p class="profil_text">{{$ukupne_pobjede}} / {{$ukupni_porazi}}</p><hr>
	
	<?php 
/*if($check_god==0){
			echo '<h4>Pozicija po godinama: nema rezulatata</h4><hr>';
		} else { 
			echo '<h4>Pozicije po godinama</h4>'; 
			foreach($pozicije_god as $godina => $pozicija_god){
				if(is_int($pozicija_god)){
					echo '<p class="profil_text">U godini '.$godina.' nalazi se na: '.$pozicija_god.' poziciji</p></br><hr>';	
			 	} else echo '<p class="profil_text">U godini'.$pozicija_god.'. nije odigrao mec</p></br><hr>'; 		
			}
		}*/

/*if($check_mj==0){
			echo '<h4>Pozicija po mjesecima: nema rezulatata</h4><hr>';
		} else { 
			echo '<h4>Pozicije po mjesecima</h4>';
			foreach($pozicije_mj as $mjesec => $pozicija_mj){
				$mjesec=(int)$mjesec; $godina = date('Y'); $godina = (int)$godina;
				if(is_int($pozicija_mj)){
					echo '<p class="profil_text">U '.$mjesec.' mjesecu '.$godina.' nalazi se na: '.$pozicija_mj.' poziciji</p></br>';	
			 	} else {
			 		$pozicija_mj=(int)$pozicija_mj; 
			 		echo '<p class="profil_text">U '.$pozicija_mj.' mjesecu nije odigrao mec</p></br>'; 		
				}
			}
			echo '<hr>';
		} */
		
	if($broj_pobjeda > 0){
		echo '<h4>Najvise pobjeda protiv:</h4>';
		foreach ($on_loser_data as $loser) {
			echo '<p class="profil_text">'.$loser->name.'</br> Broj pobjeda: '.$broj_pobjeda.'</p></br>';
		}
	} else { 
		echo '<h4>Najvise pobjeda protiv pojedinog igraca: '.$broj_pobjeda.'</h4></br>';
	}
	if($broj_poraza > 0){
		echo '<h4>Najvise poraza protiv:</h4>';
		foreach ($on_winner_data as $winner) {
			echo '<p class="profil_text">'.$winner->name.'</br> Broj poraza: '.$broj_poraza.'</p></br>';
		}
	} else { 
		echo '<h4>Najvise poraza protiv pojedinog igraca: '.$broj_poraza.'</h4></br>';
	}
	
//$me = Auth::user();

/*if(Auth::check() && ($me->id==$user->id)){ 
				echo HTML::link_to_action('users@delete', 'Izbrisi profil', array($me->id), array('class'=>'btn btn-warning','id'=>'del'));
			} */?>
@endsection