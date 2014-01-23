<?php

class LjestvicaMj extends Eloquent {
	public static $table = 'ljestvica_mj';

	public function user()
    {
        return $this->belongs_to('User');
    }
}