<?php

class Create_Tereni_Table {    

	public function up()
    {
		Schema::create('tereni', function($table) {
			$table->increments('id');
			$table->text('naziv');
		});

    }    

	public function down()
    {
		Schema::drop('tereni');

    }

}