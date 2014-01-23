<?php

class Create_Results_Table {    

	public function up()
    {
		Schema::create('results', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('suparnik_id');
			$table->integer('teren_id');
			$table->integer('podloga_id');
			$table->integer('winner');
			$table->integer('loser');
			$table->integer('game_razlika');
			$table->integer('u_final');
			$table->integer('s_final');
			$table->integer('u1');
			$table->integer('u2')->default('-1');
			$table->integer('u3')->default('-1');
			$table->integer('u4')->default('-1');
			$table->integer('u5')->default('-1');
			$table->integer('s1');
			$table->integer('s2')->default('-1');
			$table->integer('s3')->default('-1');
			$table->integer('s4')->default('-1');			
			$table->integer('s5')->default('-1');			
			$table->date('datum');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('results');

    }

}