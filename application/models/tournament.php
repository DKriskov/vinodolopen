<?php

class Tournament extends Eloquent {
	public static $table = 'tournaments';
	public static $timestamps = false;

	public function winner()
    {
        return $this->belongs_to('User', 'winner');
    }

    public function finalist()
    {
        return $this->belongs_to('User','finalist');
    }

}