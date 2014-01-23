<?php

class Ljestvica extends Eloquent {
	
	public static function generate($tip) {

		$lastMonth = date('Y-m-d', strtotime('last day of previous month'));
		$tekuciMjesec = date('m');
		$tekucaGodina = date('Y');

		$users = User::get();

		if($tip=="mjesec") {
			LjestvicaMj::where('mjesec', '=', $tekuciMjesec)->delete();
		} else if($tip=="godina") {
			LjestvicaGod::where('godina', '=', $tekucaGodina)->delete();
			$lastMonth = "$tekucaGodina-01-01";
		}

		foreach ($users as $user) {
		
			$rezultati = Result::where('datum','>', $lastMonth)
							->where(function($query) use ($user) {
							    $query->where('user_id','=',$user->id);
								$query->or_where('suparnik_id','=',$user->id);
							})
							->order_by('datum', 'desc')
							->get();
			
			$odigrao_sa = array();
			$odigraoCount = array();

			$brMeceva = 0;
			$gameRazlika = 0;
			$bodova = 0;		
			
			foreach ($rezultati as $rezultat) {
				$rezultat->game_razlika = abs($rezultat->game_razlika);
					
				if($rezultat->user_id != $user->id)
					$suparnik_id = $rezultat->user_id;
				else
					$suparnik_id = $rezultat->suparnik_id;
				
				$odigrao_sa[] = $suparnik_id;
				$odigraoCount = array_count_values($odigrao_sa);
				$brMeceva++;

				if(isset($odigraoCount[$suparnik_id]) && $odigraoCount[$suparnik_id] > 3) {
					continue;
				}

				if($rezultat->winner == $user->id) {
					$bodova++;
					$gameRazlika += $rezultat->game_razlika;
					
				} else if($rezultat->loser == $user->id) {
					$gameRazlika -= $rezultat->game_razlika;
				} else {
					if($rezultat->user_id == $user->id) {
						$gameRazlika += $rezultat->u1 - $rezultat->s1;
						$gameRazlika += $rezultat->u2 - $rezultat->s2;
						$gameRazlika += $rezultat->u3 - $rezultat->s3;
						$gameRazlika += $rezultat->u3 - $rezultat->s4;
						$gameRazlika += $rezultat->u4 - $rezultat->s5;
					} else {
						$gameRazlika += $rezultat->s1 - $rezultat->u1;
						$gameRazlika += $rezultat->s2 - $rezultat->u2;
						$gameRazlika += $rezultat->s3 - $rezultat->u3;
						$gameRazlika += $rezultat->s3 - $rezultat->u4;
						$gameRazlika += $rezultat->s4 - $rezultat->u5;
					}
				}
			}
			if($tip=="mjesec") {
				
				LjestvicaMj::create(array(
		            'user_id' => $user->id,
		            'meceva' => $brMeceva,
		            'game_razlika' => $gameRazlika,
		            'bodova' => $bodova,
		            'mjesec' => $tekuciMjesec,
					'godina' => $tekucaGodina
		        ));
			} else if($tip=="godina") {
				LjestvicaGod::create(array(
		            'user_id' => $user->id,
		            'meceva' => $brMeceva,
		            'game_razlika' => $gameRazlika,
		            'bodova' => $bodova,
		            'godina' => $tekucaGodina
		        ));
			}
		}
	}
}