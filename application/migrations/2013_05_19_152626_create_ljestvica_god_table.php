<?php

class Create_Ljestvica_God_Table {    

	public function up()
    {
		Schema::create('ljestvica_god', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('meceva');
			$table->integer('game_razlika');
			$table->text('godina');
			$table->integer('bodova');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('god');

    }

}