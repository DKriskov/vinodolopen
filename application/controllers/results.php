<?php

class Results_Controller extends Base_Controller {

	public $restful = true;   	   

    public function get_index()
    {
        return View::make('result.index');
    } 

	public function post_new()
    {
        $input = Input::all();
        $me = Auth::user();
        $validation_errors = Result::validate($input);

        if($validation_errors) {
            return Redirect::to('results/new')->with('errors',$validation_errors);
        }
        
        $game_razlika = 0;
        $final_1 = 0;
        $final_2 = 0;

        for ($i=0; $i < 5 ; $i++) { 
            if (is_numeric($input["igrac1_set"][$i])) {

                if($input["igrac1_set"][$i] == -1 || $input["igrac2_set"][$i] == -1)
                    continue;

                $game_razlika += $input["igrac1_set"][$i] - $input["igrac2_set"][$i];

                if($input["igrac1_set"][$i] > $input["igrac2_set"][$i])
                    $final_1++;
                else
                    $final_2++;
            }
        }

        if($final_1 > $final_2) {
            //pobjednik je logirani korisnik
            $winner = $me->id;
            $loser = $input["suparnik"];
        } else if($final_1 < $final_2) {
            //pobjednik je odabrani suparnik
            $winner = $input["suparnik"];
            $loser = $me->id;
        } else {
            //nerješeno
            $winner = 0;
            $loser = 0;
        }


        $new_result = Result::create(array(
            'user_id' => $me->id, 
            'suparnik_id' => $input["suparnik"],
            'teren_id' => $input["teren"],
            'podloga_id' => $input["podloga"],
            'game_razlika' => $game_razlika,
            'winner' => $winner,
            'loser' => $loser,
            'u_final' => $final_1,
            's_final' => $final_2,
            'u1' => $input["igrac1_set"][0],
            'u2' => $input["igrac1_set"][1],
            'u3' => $input["igrac1_set"][2],
            'u4' => $input["igrac1_set"][3],
            'u5' => $input["igrac1_set"][4],
            's1' => $input["igrac2_set"][0],
            's2' => $input["igrac2_set"][1],
            's3' => $input["igrac2_set"][2],
            's4' => $input["igrac2_set"][3],
            's5' => $input["igrac2_set"][4],
            'datum' => date('Y-m-d',strtotime($input["datum"])),
        ));

        if ($new_result) {
            Ljestvica::generate("mjesec");
            Ljestvica::generate("godina");
            return Redirect::to('/');
        } else {
            return Redirect::to('results/new')->with('errors',array('Došlo je do pogreške, molimo pokušajte kasnije.'));
        }
    }  

    public function get_show()
    {
        $dates = DB::query('select month(datum) as mjesec, year(datum) as godina from results group by month(datum) order by datum desc');

        return View::make('result.scores')
                    ->with('dates',$dates);
    } 

	public function get_edit()
    {
        if (Auth::guest()) { 
            return Redirect::to('/')->with('notifications',array('Za ispravak rezultata morate biti prijavljeni!'));
        }
        $me = Auth::user();
        $user_id = $me->id; 

        $rezultati = result::with(array('teren','user','suparnik','podloga'))
                        ->where('user_id', '=', $user_id)->or_where('suparnik_id', '=', $user_id)
                        ->order_by('datum', 'desc')
                        ->get();

        return View::make('result.edit')
                    ->with('rezultati',$rezultati);
    }
	
	public function get_edit_single($id)
    {
        if (Auth::guest()) { 
            return Redirect::to('/')->with('notifications',array('Za ispravak rezultata morate biti prijavljeni!'));
        }
		
		$rezultati = result::with(array('teren','user','suparnik','podloga'))
					->where('id', '=', $id)
					->get();
		
        return View::make('result.edit_single')
                    ->with('users',User::all())
                    ->with('me',Auth::user())
                    ->with('podloge',Podloga::all())
                    ->with('tereni',Teren::all())
                    ->with('rezultati',$rezultati);
    }   

	public function get_new()
    {
        if (Auth::guest()) { 
            return Redirect::to('/')->with('notifications',array('Za dodavanje rezultata morate biti prijavljeni!'));
        }
        return View::make('result.new')
                    ->with('users',User::all())
                    ->with('me',Auth::user())
                    ->with('podloge',Podloga::all())
                    ->with('tereni',Teren::all());
    }    

	public function put_update()
    {
        $input = Input::all();
        $validation_errors = Result::validate($input);
        
        if($validation_errors) {
            return Redirect::to('results/new')->with('errors',$validation_errors);
        }
        
        $game_razlika = 0;
        $final_1 = 0;
        $final_2 = 0;

        for ($i=0; $i < 5 ; $i++) { 
            if (is_numeric($input["igrac1_set"][$i])) {

                if($input["igrac1_set"][$i] == -1 || $input["igrac2_set"][$i] == -1)
                    continue;

                $game_razlika += $input["igrac1_set"][$i] - $input["igrac2_set"][$i];

                if($input["igrac1_set"][$i] > $input["igrac2_set"][$i])
                    $final_1++;
                else
                    $final_2++;
            }
        }

        if($final_1 > $final_2) {
            //pobjednik je logirani korisnik
            $winner = $input["user"];
            $loser = $input["suparnik"];
        } else if($final_1 < $final_2) {
            //pobjednik je odabrani suparnik
            $winner = $input["suparnik"];
            $loser = $input["user"];
        } else {
            //nerješeno
            $winner = 0;
            $loser = 0;
        }

        $edit_result = Result::find($input["rezultat_id"]);
        
            $edit_result->user_id = $input["user"]; 
            $edit_result->suparnik_id = $input["suparnik"];
            $edit_result->teren_id = $input["teren"];
            $edit_result->podloga_id = $input["podloga"];
            $edit_result->game_razlika = $game_razlika;
            $edit_result->winner = $winner;
            $edit_result->loser = $loser;
            $edit_result->u_final = $final_1;
            $edit_result->s_final = $final_2;
            $edit_result->u1 = $input["igrac1_set"][0];
            $edit_result->u2 = $input["igrac1_set"][1];
            $edit_result->u3 = $input["igrac1_set"][2];
            $edit_result->u4 = $input["igrac1_set"][3];
            $edit_result->u5 = $input["igrac1_set"][4];
            $edit_result->s1 = $input["igrac2_set"][0];
            $edit_result->s2 = $input["igrac2_set"][1];
            $edit_result->s3 = $input["igrac2_set"][2];
            $edit_result->s4 = $input["igrac2_set"][3];
            $edit_result->s5 = $input["igrac2_set"][4];
            $edit_result->datum = date('Y-m-d',strtotime($input["datum"]));

            $edit_result->save();

        if ($edit_result) {
            Ljestvica::generate("mjesec");
            Ljestvica::generate("godina");
			 return Redirect::to('results/edit');
        } else {
            return Redirect::to('results/new')->with('errors',array('Došlo je do pogreške, molimo pokušajte kasnije.'));
        }
    }    

	public function get_destroy($id)
    {
        if (Auth::guest()) { 
            return Redirect::to('/')->with('notifications',array('Za brisanje rezultata morate biti prijavljeni!'));
        }

        $del=result::find($id);
        $del->delete();

        if ($del) {
            Ljestvica::generate("mjesec");
            Ljestvica::generate("godina");
            return Redirect::to('/results/edit')->with('notifications',array('Rezultat je izbrisan'));
        } else {
            return Redirect::to('results/edit')->with('errors',array('Došlo je do pogreške, molimo pokušajte kasnije.'));
        }
    }

	public function get_head()
    {
        return View::make('result.head')
                    ->with('users',User::all());
    }

    public function get_Head2head()
    {
        $player1 = Input::get('player1');
        $player2 = Input::get('player2');

        $player1_win = $this->build($player1,$player1,$player2);
        $player2_win = $this->build($player2,$player1,$player2);
        $draw = $this->build(0,$player1,$player2);

        $player1_win = DB::query($player1_win);
        $player2_win = DB::query($player2_win);
        $draw = DB::query($draw);
        
        $id_set = DB::query("SELECT id FROM results 
                            WHERE ((user_id = $player1 AND suparnik_id = $player2)
                            OR (user_id = $player2 AND suparnik_id = $player1))");

        $id_evi = array();

        foreach ($id_set as $id) {
            $id_evi[]=$id->id;
        }

        if(count($id_evi)==0){     
            
            $no_scores = 0;

            return View::make('result.head')
                    ->with('users',User::all())
                    ->with('no_scores',$no_scores);
        } else {

            foreach ($player1_win as $value) {
                $rez1 = $value;
            }

            foreach ($player2_win as $value) {
                $rez2 = $value;
            }

            foreach ($draw as $value) {
                $rez0 = $value;
            }

            $player1w = $rez1->broj;
            $player2w = $rez2->broj;
            $nerj = $rez0->broj;
            
            $rezultati = result::with(array('teren','user','suparnik','podloga'))
                    ->where_In('id', $id_evi)
					->order_by('datum','desc')
                    ->get();

            $users = User::order_by('id')->get();

            return View::make('result.head')
                    ->with('rezultati',$rezultati)
                    ->with('users',$users)
                    ->with('player1w',$player1w)
                    ->with('player2w',$player2w)
                    ->with('nerj',$nerj);
        }   
    }

    private function build($tip,$player1,$player2) {

        $score = "SELECT COUNT(*) AS broj 
                    FROM results WHERE 
                    (winner = $tip AND 
                    ((user_id = $player1 AND suparnik_id = $player2)
                    OR (user_id = $player2 AND suparnik_id = $player1)))";

        return $score;
    }
	
}