<?php

class Result extends Eloquent 
{
	public static $rules = array(
        'suparnik'  => 'required',
        'igrac1_set' => 'required',
        'igrac2_set' => 'required'
    );

    public static function validate($input)
    {
    	$v = Validator::make($input, static::$rules);
    	$v->valid();

    	return $v->errors->all();
    }

    public function teren()
    {
        return $this->belongs_to('Teren');
    }

    public function user()
    {
        return $this->belongs_to('User');
    }

    public function podloga()
    {
        return $this->belongs_to('Podloga');
    }

    public function suparnik()
    {
        return $this->belongs_to('User','suparnik_id');
    }
}