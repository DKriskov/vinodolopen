<?php

class Registered extends Eloquent {
	
	public static $timestamps = false;

	public function turnir()
    {
        return $this->belongs_to('User','user_id');
    }
}