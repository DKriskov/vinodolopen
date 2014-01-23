<?php

class Create_Ljestvica_Mj_Table {    

	public function up()
    {
		Schema::create('ljestvica_mj', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('meceva');
			$table->integer('game_razlika');
			$table->text('mjesec');
			$table->integer('bodova');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('mj');

    }

}