<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvPurchaseordersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchaseorders', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id');
            $table->string('po_number');
            $table->decimal('total_amount',10,2);
            $table->dateTime('ordered_on');
            $table->dateTime('received_on');
            $table->dateTime('due_on');
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
        Schema::dropIfExists('purchaseorders');
	}

}
