<?php

use Illuminate\Database\Migrations\Migration;

class CreateNewUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	
		Schema::create('users', function($table){

			$table->increments('id');
			$table->string('name', 255);
			$table->string('username', 45);
			$table->string('password', 128);
			$table->string('email', 128)->unique();
			$table->boolean('active', 1);
			$table->timestamps();

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');	

	}
}