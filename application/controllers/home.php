<?php

class Home_Controller extends Base_Controller {

	public function action_index()
	{
		Ljestvica::generate("mjesec");
        Ljestvica::generate("godina");
		$tekucaGodina = date('Y');
		$tekuciMjesec = date('m');
		
		return View::make('home.index')
			->with("rezultati",result::with(array('teren','user','suparnik','podloga'))
						->order_by('datum', 'desc')
						->take(5)
						->get())
			->with("ljestvica_mj",LjestvicaMj::with(array('user'))
						->where('mjesec','=',$tekuciMjesec)
						->where('meceva','>',0)
				   		->order_by('bodova', 'desc')
						->order_by('game_razlika', 'desc')
						->order_by('meceva', 'desc')
						->take(6)
						->get())
			->with("ljestvica_god",LjestvicaGod::with(array('user'))
						->where('meceva','>',0)
				   		->order_by('bodova', 'desc')
						->order_by('game_razlika', 'desc')
						->order_by('meceva', 'desc')
						->take(6)
						->get())
			->with('tekucaGodina',$tekucaGodina)
			->with('tekuciMjesec',$tekuciMjesec);
	}

}