<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiveTable extends Migration {

	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('receives',function($table){
			$table->increments('id');
			$table->integer('purchaseorder_id');
			$table->integer('item_id');			
			$table->integer('actual_quantity');
			$table->integer('remaining_balance');
                        $table->decimal('actual_price',10,2);
                        $table->string('receipt_number',20);
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
		Schema::drop('receives');
	}

}
