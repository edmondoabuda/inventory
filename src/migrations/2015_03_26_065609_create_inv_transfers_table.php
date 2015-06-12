<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvTransfersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transfers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id_from');
            $table->integer('warehouse_id_to');
            $table->integer('qty');
            $table->integer('item_id');
            $table->boolean('disabled');
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
		Schema::dropIfExists('transfers');
	}

}
