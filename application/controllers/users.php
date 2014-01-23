<?php

class Users_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
    {
        return View::make('user.index')
                    ->with('users',User::all());
    }    

    public function get_new()
    {
        return View::make('user.new');
    }  

	public function post_create()
    {
        $input = Input::all();
        $response = User::parse_signed_request($input['signed_request'], 'e061d93826953587ee4b1d6cb6cdd254');
        $registration = $response["registration"];

        $validation_errors = User::validate($registration);

        if($validation_errors) {
            return Redirect::to('users/new')->with('validation_errors',$validation_errors);
        }
        
        $check = User::where('fb_id', '=', $response["user_id"])->first();
        $db_data = array(
            "email" => $registration["email"],
            "password" => Hash::make($registration["password"]),           
            "name" => $registration["name"],
            "fb_id" => $response["user_id"]
        );

        if($check)
            $new_user = User::update($check->id,$db_data);
        else
            $new_user = User::create($db_data);

        if ($new_user) {
			Ljestvica::generate("mjesec");
            Ljestvica::generate("godina");
			
            return $this->post_login(array(
                'username'  => $registration["email"],
                'password'  => $registration["password"],
                'remember' => true 
            ));
        } else {
            return Redirect::to('users/new')->with('validation_errors',array('Greska prilikom registracije!'));
        }
    }    

    public function post_login($credentials=null) {
        if($credentials==null) {
            $credentials = Input::all();
        }
        
        if( Auth::attempt($credentials) )
        {
            return Redirect::to('home');
        }
        else {
            return Redirect::to('home')->with('login_errors',array('Pogresan email i/ili password, molimo pokusajte ponovo!'));
        }
    }

	public function get_profil($id)
    {
        $tekucagodina = date('Y');
        $tekucimjesec = date('m');
        $pocetnimjesec = 5;
		//$pocetnagodina = 2013;
        $razlika_mj = $tekucimjesec - $pocetnimjesec;
		//$razlika_god = $tekucagodina - $pocetnagodina;

        $rezultati = result::with(array('user','suparnik'))
                    ->where('user_id', '=', $id)
                    ->get();

        $winner_set = DB::query("SELECT loser, COUNT(*) AS pobjede FROM `results` WHERE winner = $id GROUP BY (loser) ORDER BY pobjede desc LIMIT 1");
        $loser_set = DB::query("SELECT winner, COUNT(*) AS porazi FROM `results` WHERE loser = $id GROUP BY winner ORDER BY porazi desc LIMIT 1");
        $user=user::find($id);
        $ukupne_pobjede = DB::table('results')->where('winner','=', $id)->count();
        $ukupni_porazi = DB::table('results')->where('loser','=', $id)->count();

        if(count($winner_set)>0){
            foreach ($winner_set as $winner) {
                $loser_id = $winner->loser;
                $broj_pobjeda = $winner->pobjede;
            }

            $on_loser_data = user::where('id', '=', $loser_id)
                                ->get();
        } else {
            $broj_pobjeda = 0;
            $on_loser_data= 0;
        }
        
        if(count($loser_set)>0){
            foreach ($loser_set as $loser) {
                $winner_id = $loser->winner;
                $broj_poraza = $loser->porazi;
            }

            $on_winner_data = user::where('id', '=', $winner_id)
                                ->get();
        } else {
            $broj_poraza = 0;
            $on_winner_data= 0;
        }

		/*$j=0;
        for ($i=0; $i <= $razlika_mj; $i++) { 

            $mjesec=$tekucimjesec - $j;
            $mjesec='0'.strval($mjesec);
    
            $ljestvica[$i] = LjestvicaMj::where('meceva','>', 0)
                                ->where('mjesec','=',$mjesec)
                                ->where('godina','=',$tekucagodina)
                                ->order_by('bodova','desc')
								->order_by('game_razlika','desc')
                                ->get();
            $j++;
        }

        $k=0;
		for ($i=0; $i <= $razlika_god; $i++) { 

            $godina=$tekucagodina - $k;
            
            $ljestvica_godina[$i] = LjestvicaGod::where('meceva','>', 0)
                                ->where('godina','=',$godina)
                                ->order_by('bodova','desc')
								->order_by('game_razlika','desc')
                                ->get();
            $k++;
        }
        
		$pozicije_godine = array();
        foreach ($ljestvica_godina as $god) {
            $i=1;
            $positions_num_god=count($god);
            foreach ($god as $red) {
                if($red->user_id == $id)
                    break;
                $i++;
            }
            
            if($i <= $positions_num_god){
                $pozicije_godine[$red->godina]=$i;
            } else {
                $pozicije_godine['godina']=$red->godina;
            }
        }

        $pozicije_mjeseci = array();
        foreach ($ljestvica as $mj) {
            $i=1;
            $positions_num=count($mj);
            foreach ($mj as $red) {
                if($red->user_id == $id)
                    break;
                $i++;
            }

            if($i <= $positions_num){
                $pozicije_mjeseci[$red->mjesec]=$i;
            } else {
                $pozicije_mjeseci['mjesec']=$red->mjesec;
            }
        }*/
        
        return View::make('user.single')
                    ->with('user',$user)
                    ->with('ukupne_pobjede',$ukupne_pobjede)
                    ->with('ukupni_porazi',$ukupni_porazi)
			//->with('pozicije_mj',$pozicije_mjeseci)
			//->with('check_mj',$positions_num)
			//->with('pozicije_god',$pozicije_godine)
			//->with('check_god',$positions_num_god)
                    ->with('broj_pobjeda',$broj_pobjeda)
                    ->with('on_loser_data',$on_loser_data)
                    ->with('broj_poraza',$broj_poraza)
                    ->with('on_winner_data',$on_winner_data);
    }    

    public function get_logout()
    {
        Auth::logout();
        return Redirect::to('home');
    } 

	/*public function get_delete($id)
    {
         if (Auth::guest()) { 
            return Redirect::to('/')->with('notifications',array('Za brisanje profila morate biti prijavljeni!'));
        }
        $del=user::find($id);

        $results_del=result::where('user_id','=',$id)
                            ->or_where('suparnik_id', '=', $id)
                            ->get();

        $ljestvica_mj_del=ljestvicamj::where('user_id','=',$id)
                            ->get();

        $ljestvica_god_del=ljestvicagod::where('user_id','=',$id)
                            ->get();
        
        foreach ($ljestvica_mj_del as $ljes_mj) {
            $ljes_mj->delete();
        }  

        foreach ($ljestvica_god_del as $ljes_god) {
            $ljes_god->delete();
        }     

        foreach ($results_del as $result_del) {
            $result_del->delete();
        }
        
        $del->delete();

        if ($del) {
            return Redirect::to('/users')->with('notifications',array('Profil je izbrisan'));
        } else {
            return Redirect::to('/users')->with('errors',array('Došlo je do pogreške, molimo pokušajte kasnije.'));
        }
    }*/

}