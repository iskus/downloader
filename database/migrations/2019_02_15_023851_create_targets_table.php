<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'targets',
			function (Blueprint $table) {
				$table->increments('id');
				$table->enum(
					'status',
					[
						'pending',
						'downloading',
						'complete',
						'error',
					]
				)->default('pending');
				$table->string('link');
				$table->timestamps();
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('targets');
	}
}