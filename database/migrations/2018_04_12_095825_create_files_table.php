<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('fileRealName');
			$table->string('fileName');
			$table->integer('book_id')->unsigned();
			$table->integer('filetable_id')->unsigned();
			$table->string('filetable_type');
			$table->string('fileType');
			$table->integer('fileSize')->unsigned();
			$table->integer('fileCounter')->unsigned();
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
		Schema::drop('files');
	}

}
