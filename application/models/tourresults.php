<?php

class Tourresults extends Eloquent {
	public static $table = 'tour_rez';
	public static $timestamps = false;

	public function player1()
    {
        return $this->belongs_to('User', 'p1_id');
    }

    public function player2()
    {
        return $this->belongs_to('User','p2_id');
    }

    public function turnir()
    {
        return $this->belongs_to('Tournament','turnir_id');
    }
}