<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvOrderlinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orderlines',function($table){
			$table->increments('id');
			$table->integer('order_id');				
			$table->integer('item_id');
			$table->decimal('price_each',10,2);
			$table->decimal('price_ext',10,2);
            $table->integer('qty');          
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
		 Schema::dropIfExists('orderlines');
	}

}
