<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvPoLinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('po_lines', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('purchaseorder_id');
            $table->integer('item_id');
            $table->integer('qty');
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
		Schema::dropIfExists('po_lines');
	}

}
