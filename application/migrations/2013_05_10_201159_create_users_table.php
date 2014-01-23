<?php

class Create_Users_Table {    

	public function up()
    {
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('email');
			$table->string('password');			
			$table->string('name');
			$table->string('fb_id');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('users');

    }

}