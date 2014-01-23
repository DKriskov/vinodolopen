<?php

class Ajax_Controller extends Base_Controller {

	public $restful = true;

	public function post_index()
    {
    	if (Request::ajax())
            {
                $mjesec = Input::get('mjesec');
                $godina = Input::get('godina');
                $datum = $godina.'-%'.$mjesec.'-%%';

                $rezultati = result::with(array('teren','user','suparnik','podloga'))
                		->where('datum', 'LIKE', $datum )
						->order_by('datum', 'desc')
						->get();

				foreach($rezultati as $rezultat) {
					$rezultat->datum = date('d.m.Y.',strtotime($rezultat->datum));
				}
				
				$rezultati = json_encode($rezultati);
				return $rezultati;
            }
    }
}