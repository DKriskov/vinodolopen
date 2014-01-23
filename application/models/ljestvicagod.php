<?php

class LjestvicaGod extends Eloquent {
	public static $table = 'ljestvica_god';

	public function user()
    {
        return $this->belongs_to('User');
    }
}