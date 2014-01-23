<?php

class Tour_Controller extends Base_Controller {

	public $restful = true; 	   

    public function get_sign_in()
    {

    	//$pozicije = DB::query("select user_id, bodova, @rownum:=@rownum+1 as pozicija from ljestvica_god, (SELECT @rownum:=0) r where godina = $tekucaGodina order by bodova desc");
    	
        $nositelji = $this->nositelji();
        $players_num = $this->players_num();

        $next_tour_date = $this->tournament_date();
        if (!empty($next_tour_date)){
            $next_tour_date = $next_tour_date->start_date;
        }

        return View::make('tour.sign_in')
        			->with('signed',$nositelji)
                    ->with('players_num', $players_num)
                    ->with('next_tour_date',$next_tour_date);
    }
    public function get_draw()
    {
        $turniri = DB::query("SELECT tournaments.id, tournaments.start_date, users.name as winner FROM tournaments LEFT JOIN users ON tournaments.winner=users.id WHERE started = 1");
                        
        return View::make('tour.tournaments')
                    ->with('turniri',$turniri);
    } 
    public function get_single_draw($turnir_id)
    {       
        $turnir_id = (int)$turnir_id;
        $date = DB::table('tournaments')->select('start_date')->where('id', '=', $turnir_id)->get();
        $date = $date[0]->start_date;

        $a_stages = $this->stages('a%',$turnir_id);
        $b_stages = $this->stages('b%',$turnir_id);
        $c_stages = $this->stages('c%',$turnir_id);
        $d_stages = $this->stages('d',$turnir_id);                   
        $e_stages = $this->stages('e',$turnir_id); 
        $seeded_pairs = $this->sortstage($a_stages);

        return View::make('tour.single_tournament')
                    ->with('date',$date)
                    ->with('seeded_pairs',$seeded_pairs)
                    ->with('b_stages',$b_stages)
                    ->with('c_stages',$c_stages)
                    ->with('d_stages',$d_stages)
                    ->with('e_stages',$e_stages);
    }
    public function post_signed()
    {
        $user_id = Input::get('user');
        $players_num = $this->players_num();
        
        if($players_num <= 16){
            $new_player = new Registered;
            $new_player->user_id = $user_id;
            $new_player->save();
        }
        if ($new_player) {
            return Redirect::to('tour/sign_in')->with('messages',array('Uspjesno ste registrirani'));
        } else {
            return Redirect::to('tour/sign_in')->with('messages',array('Došlo je do pogreške, molimo pokušajte kasnije.'));
        }

    } 
    public function post_signout()
    {
        $user_id = (int)Input::get('user_id');

        $del = DB::table('registereds')->where('user_id', '=', $user_id)->delete();
        if ($del) {
            return Redirect::to('tour/sign_in')->with('messages',array('Uspjesno ste odjavljeni iz turnira'));
        } else {
            return Redirect::to('tour/sign_in')->with('messages',array('Došlo je do pogreške, molimo pokušajte kasnije.'));
        }
    }
    public function get_start_tour()
    {

        $tour_id = Tournament::where('started','=',0)
                            ->order_by('id','desc')
                            ->first();

        $players_num = $this->players_num();
        $tour_id = (int)$tour_id->id;
        DB::table('tournaments')->where('id', '=', $tour_id)
                                ->update(array(
                                    'started' => 1,
                                    'players_num' => $players_num
                                ));

        $nositelji = $this->nositelji();
        $players_num = $this->players_num();

        $nenositelji = array();
        $i=1;
        $p=2;
        $broj_nositelja = 16 - $players_num;
        $broj_nenositelja = $players_num - $broj_nositelja;

        if ($players_num == 8){
            $broj_nositelja = 4;
            $broj_nenositelja = 4;
        }
		if ($players_num == 16){
            $broj_nositelja = 8;
            $broj_nenositelja = 8;
        }
        $b_stage_shuff = array(1,4,3,2);
        foreach ($nositelji as $nositelj) {
            if(($i<=$broj_nositelja) && ($i<=4)){
                Tourresults::create(array(
                    'turnir_id' => $tour_id,
                    'stage' => 'a'.$i,
                    'p1_id' => $nositelj->user_id,
                    'winner' => -1
                ));
                if($players_num != 8 && $players_num != 16){
                    Tourresults::create(array(
                        'turnir_id' => $tour_id,
                        'stage' => 'b'.$b_stage_shuff[$i-1],
                        'p1_id' => $nositelj->user_id,
                        'winner' => -1
                    ));
                }
            } elseif (($i<=$broj_nositelja) && ($i>4)){
                Tourresults::create(array(
                    'turnir_id' => $tour_id,
                    'stage' => 'a'.$i,
                    'p1_id' => $nositelj->user_id,
                    'winner' => -1
                ));
                DB::table('tour_rez')->where('stage', '=', 'b'.$p)
                                    ->where('turnir_id', '=', $tour_id)
                                    ->update(array(
                                        'p2_id' => $nositelj->user_id,
                                        'winner' => 0
                                        ));
                $p++;
            } elseif($i>$broj_nositelja) {
                $nenositelji[]=$nositelj->user_id;
            }

            $i++;
        }

        $prazno = 4 - $broj_nositelja;
        $b_prazno = array_slice($b_stage_shuff, $prazno);
        
        if ($broj_nositelja < 4) {
            for ($t=0; $t < $prazno; $t++) { 
               Tourresults::create(array(
                    'turnir_id' => $tour_id,
                    'stage' => 'b'.$b_prazno[$t],
                    'p1_id' => 0,
                    'p2_id' => 0,
                    'winner' => -1
                ));
            }
        }
        
        if ($players_num == 16){
            for ($r=1; $r <= 4; $r++) { 
               Tourresults::create(array(
                    'turnir_id' => $tour_id,
                    'stage' => 'b'.$r,
                    'p1_id' => 0,
                    'p2_id' => 0,
                    'winner' => -1
                ));
            }
        }

        shuffle($nenositelji);
        $shuffnenositelji = array_chunk($nenositelji, $broj_nenositelja/2);
        
        $j=$broj_nositelja+1;
        $k=$broj_nositelja+1;

        if ($players_num == 8 || $players_num == 16){
            $m = 1;
            foreach ($nenositelji as $fourplay) {
                DB::table('tour_rez')->where('stage', '=', 'a'.$m)
                            ->where('turnir_id', '=', $tour_id)
                            ->update(array(
                                'p2_id' => $fourplay,
                                'winner' => 0
                                ));
                $m++;
            }
        } else {
            foreach ($shuffnenositelji as $key => $value) {
                if($key==0){
                    foreach ($value as $test) {
                        Tourresults::create(array(
                                'turnir_id' => $tour_id,
                                'stage' => 'a'.$j,
                                'p1_id' => $test
                            ));
                        $j++;
                    }
                } elseif ($key==1) {
                    foreach ($value as $test) {
                        DB::table('tour_rez')->where('stage', '=', 'a'.$k)
                                    ->where('turnir_id', '=', $tour_id)
                                    ->update(array('p2_id' => $test));
                        $k++;
                    }
                }
            }
        }
        return Redirect::to('tour/draw');
    }
    public function get_delete_tour()
    {
        DB::table('registereds')->delete();
        return Redirect::to('tour/sign_in');
    }
    public function get_admin()
    {
        if(Auth::user()){
            $players_num = $this->players_num();
            $start_tour = DB::query("SELECT count(*) as start FROM `tournaments` where started = 0");
            $start_tour = (int)$start_tour[0]->start;
			
			$turnir_id = $this->turnir_id();

            $results = Tourresults::with(array('player1','player2'))
                            ->where('turnir_id','=', $turnir_id)
                            ->where('winner','=', 0)
                            ->get();  
			
			$users = DB::query("SELECT users.id, users.name, registereds.user_id AS prijavljeni FROM users LEFT JOIN registereds ON users.id=registereds.user_id");

            return View::make('tour.admin')
                        ->with('players_num',$players_num)
                        ->with('start_tour',$start_tour)
                        ->with('results',$results)
						->with('not_signed_in', $users);
        } else {
            return Redirect::to('/')->with('notifications',array('Za admin area morate biti prijavljeni!'));
        }
    }
    public function post_setTour_date()
    {
        $input = Input::get('next_tour_date');

        $new_tour = Tournament::create(array(
            'start_date' => $input 
        ));
        if ($new_tour) {
            return Redirect::to('tour/sign_in')->with('messages',array('Postavljen je datum turnira, prijeve mogu poceti'));
        }
    }
    public function get_result()
    {
        if(Auth::user()){

            $me = Auth::user();
            $user_id = (int)$me->id;
			//$user_id = 9;
            
            $turnir_id = $this->turnir_id();
			
            $tour_rez = Tourresults::with(array('player1','player2'))
                            ->where('turnir_id','=', $turnir_id)
                            ->where('winner','=', 0)
                            ->where(function($query) use ($user_id) {
                                $query->where('p1_id','=',$user_id);
                                $query->or_where('p2_id','=',$user_id);
                            })
                            ->first();

            return View::make('tour.result')
                        ->with('tour_rez',$tour_rez);
        } else {
            return Redirect::to('/')->with('notifications',array('Za upis rezultata morate biti prijavljeni!'));
        }
    }
    public function post_result()
    {
        $input= Input::all();
        $me = Auth::user();

        $turnir_id = $this->turnir_id();

        $game_razlika = 0;
        $final_1 = 0;
        $final_2 = 0;

        $p1_id = $input['p1_id'];
        $p2_id = $input['p2_id'];
        $rez_id = $input['rez_id'];
        $stage = $input['stage'];

        $players_num = $this->players_num();

        for ($i=0; $i < 3 ; $i++) { 
            if (is_numeric($input["igrac1_set"][$i])) {

                if($input["igrac1_set"][$i] == -1 || $input["igrac2_set"][$i] == -1)
                    continue;

                $game_razlika += abs($input["igrac1_set"][$i] - $input["igrac2_set"][$i]);

                if($input["igrac1_set"][$i] > $input["igrac2_set"][$i])
                    $final_1++;
                else
                    $final_2++;
            }
        }

        if($final_1 > $final_2) {
            $winner = $p1_id;
            $loser = $p2_id;
        } else if($final_1 < $final_2) {
            $winner = $p2_id;
            $loser = $p1_id;
        }
        
        DB::table('tour_rez')->where('id', '=', $rez_id)
                            ->update(array(
                                'winner' => $winner,
                                'loser' => $loser,
                                'p1_final' => $final_1,
                                'p2_final' => $final_2,
                                'p1_set1' => $input["igrac1_set"][0],
                                'p1_set2' => $input["igrac1_set"][1],
                                'p1_set3' => $input["igrac1_set"][2],
                                'p2_set1' => $input["igrac2_set"][0],
                                'p2_set2' => $input["igrac2_set"][1],
                                'p2_set3' => $input["igrac2_set"][2],
                                ));

        if($players_num > 8) { 
            if (preg_match('/^a/', $stage)){
                if (($stage == 'a8') || ($stage == 'a1')){
                    $new_stage = 'b1';
                }
                if (($stage == 'a5') || ($stage == 'a4')){
                    $new_stage = 'b2';
                }
                if (($stage == 'a6') || ($stage == 'a3')){
                    $new_stage = 'b3';
                }
                if (($stage == 'a7') || ($stage == 'a2')){
                    $new_stage = 'b4';
                }
            }

        
            if (preg_match('/^b/', $stage)){
                if ($stage == 'b1'){
                    $new_stage = 'c1';
                }
                if ($stage == 'b2'){
                    $new_stage = 'c1';
                }
                if ($stage == 'b3'){
                    $new_stage = 'c2';
                }
                if ($stage == 'b4'){
                    $new_stage = 'c2';
                }
            }

            if (preg_match('/^c/', $stage)){
                $new_stage = 'd';
            }

            if (preg_match('/d/', $stage)){
                $new_stage = 'e';
            }
        }

        if($players_num == 8) { 
            if (preg_match('/^a/', $stage)){
                if (($stage == 'a4') || ($stage == 'a1')){
                    $new_stage = 'b1';
                }
                if (($stage == 'a3') || ($stage == 'a2')){
                    $new_stage = 'b2';
                }
            }
        
            if (preg_match('/^b/', $stage)){
                    $new_stage = 'c';
            }

            if (preg_match('/c/', $stage)){
                $new_stage = 'd';
            }
        }

        if($players_num != 8){
            
            if ((preg_match('/^a[5-8]/', $stage)) && ($players_num > 8)) {
                
                $this->player_update('p2_id',$new_stage,$turnir_id,$winner);
    
                $this->both_players($turnir_id,$new_stage);
            }
            if ((preg_match('/^a[1-4]/', $stage)) && ($players_num > 8)) {
                
                $this->player_update('p1_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if (preg_match('/^b1/', $stage) || preg_match('/^b2/', $stage))  {
    
                $this->row_exist($turnir_id,$new_stage);
            }
    
            if(preg_match('/^b1/', $stage)) {
                
                $this->player_update('p1_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            } 
    
            if(preg_match('/^b2/', $stage)) {
                
                $this->player_update('p2_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if (preg_match('/^b3/', $stage) || preg_match('/^b4/', $stage))  {
    
                $this->row_exist($turnir_id,$new_stage);
            }
    
            if(preg_match('/^b3/', $stage)) {
                
                $this->player_update('p1_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if(preg_match('/^b4/', $stage)) {
                
                $this->player_update('p2_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if (preg_match('/c1/', $stage) || preg_match('/c2/', $stage))  {
    
                $this->row_exist($turnir_id,$new_stage);
            }
    
            if(preg_match('/c1/', $stage)) {
            
                $this->player_update('p1_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if(preg_match('/c2/', $stage)) {

                $this->player_update('p2_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if (preg_match('/d/', $stage))  {
    
                $this->winner($turnir_id,$new_stage,$winner);
                $this->finalist($turnir_id,$winner,$loser);
            }
        }

        if ($players_num == 8) {

            if (preg_match('/^a1/', $stage) || preg_match('/^a4/', $stage))  {
        
                $this->row_exist($turnir_id,$new_stage);
            }
    
            if(preg_match('/^a1/', $stage)) {
                
                $this->player_update('p1_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
            if(preg_match('/^a4/', $stage)) {
                
                $this->player_update('p2_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if (preg_match('/^a3/', $stage) || preg_match('/^a2/', $stage))  {
    
                $this->row_exist($turnir_id,$new_stage);
            }
    
            if(preg_match('/^a2/', $stage)) {
                
                $this->player_update('p1_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if(preg_match('/^a3/', $stage)) {
    
                $this->player_update('p2_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }

            if (preg_match('/b1/', $stage) || preg_match('/b2/', $stage))  {
        
                $this->row_exist($turnir_id,$new_stage);
            }
    
            if(preg_match('/b1/', $stage)) {

                $this->player_update('p1_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }
    
            if(preg_match('/b2/', $stage)) {

                $this->player_update('p2_id',$new_stage,$turnir_id,$winner);
                $this->both_players($turnir_id,$new_stage);
            }

            if (preg_match('/c/', $stage))  {

                $this->winner($turnir_id,$new_stage,$winner);
                $this->finalist($turnir_id,$winner,$loser);
            }
        }
        $new_result = Result::create(array(
            'user_id' => $p1_id, 
            'suparnik_id' => $p2_id,
            'teren_id' => 3,
            'podloga_id' => 3,
            'game_razlika' => $game_razlika,
            'winner' => $winner,
            'loser' => $loser,
            'u_final' => $final_1,
            's_final' => $final_2,
            'u1' => $input["igrac1_set"][0],
            'u2' => $input["igrac1_set"][1],
            'u3' => $input["igrac1_set"][2],
            's1' => $input["igrac2_set"][0],
            's2' => $input["igrac2_set"][1],
            's3' => $input["igrac2_set"][2],
            'datum' => date('Y-m-d'),
        ));

        if ($new_result) {
            Ljestvica::generate("mjesec");
            Ljestvica::generate("godina");
            return Redirect::to('tour/draw');
        } else {
            return Redirect::to('tour/draw')->with('errors',array('Došlo je do pogreske pri upisivanju rezultata'));
        }
    }
    private function sortstage($origarray){
        $res = array();
        $seed_algoritam = array('0','7','4','3','2','5','6','1');
        
        if(count($origarray) == 4){
            $seed_algoritam = array('0','3','2','1');
        }
        foreach ($seed_algoritam as $key) {
            $res[] = $origarray[$key];
        }

        return $res;
    }
    private function players_num(){
        $players_num = DB::query("SELECT count(*) as players FROM `registereds`");
        $players_num = (int)$players_num[0]->players; 
        
        return $players_num;
    }
    private function nositelji(){
         
        $nositelji = DB::query("SELECT ljestvica_god.user_id, ljestvica_god.bodova, users.name FROM ljestvica_god INNER JOIN registereds ON ljestvica_god.user_id=registereds.user_id INNER JOIN users ON registereds.user_id=users.id order by ljestvica_god.bodova desc, ljestvica_god.game_razlika desc, ljestvica_god.meceva desc");
        return $nositelji;
    }
    private function tournament_date(){
        $data = Tournament::where('started','=',0)
                                    ->order_by('id','desc')
                                    ->first();
        return $data;
    }
    private function turnir_id(){
        $data = Tournament::where('started','=',1)
                                    ->order_by('id','desc')
                                    ->first();

        if(!empty($data)){
            	$data = (int)$data->id;
    		}
        return $data;
    }
    private function row_exist($turnir_id,$new_stage){
        $row_exist = Tourresults::where('turnir_id', '=', $turnir_id)
                                    ->where('stage', '=', $new_stage)
                                    ->first();
        if (empty($row_exist)){                        
            Tourresults::create(array(
                                'turnir_id' => $turnir_id,
                                'stage' => $new_stage,
                                'p1_id' => 0,
                                'p2_id' => 0,
                                'winner' => -1
                            ));
        }
    }
    private function both_players($turnir_id,$new_stage){
        $both_players = Tourresults::where('turnir_id', '=', $turnir_id)
                                    ->where('stage', '=', $new_stage)
                                    ->where('p1_id','!=',0)
                                    ->where('p2_id','!=',0)
                                    ->first();

        if (!empty($both_players)) {
            DB::table('tour_rez')->where('stage', '=', $new_stage)
                        ->where('turnir_id', '=', $turnir_id)
                        ->update(array(
                                'winner' => 0
                                ));
        }
    }
    private function stages($letter,$turnir_id){
        $stage = Tourresults::with(array('player1','player2'))
                            ->where('turnir_id', '=', $turnir_id)
                            ->where('stage','LIKE',$letter)
                            ->order_by('stage','asc')
                            ->get();
        return $stage;
    }
    private function player_update($player,$new_stage,$turnir_id,$winner){
        DB::table('tour_rez')->where('stage', '=', $new_stage)
                                    ->where('turnir_id', '=', $turnir_id)
                                    ->update(array(
                                            $player => $winner
                                            ));
    }
    private function winner($turnir_id,$new_stage,$winner){
        Tourresults::create(array(
                            'turnir_id' => $turnir_id,
                            'stage' => $new_stage,
                            'p1_id' => $winner,
                            'p2_id' => 0,
                            'winner' => -1
                        ));
    }
    private function finalist($turnir_id,$winner,$loser){
        DB::table('tournaments')->where('id', '=', $turnir_id)
                                ->update(array(
                                            'winner' => $winner,
                                            'finalist' => $loser
                                        ));
    }
}
