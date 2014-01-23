<?php

class Create_Podloga_Table {    

	public function up()
    {
		Schema::create('podloga', function($table) {
			$table->increments('id');
			$table->string('podloga');
	});

    }    

	public function down()
    {
		Schema::drop('podloga');

    }

}