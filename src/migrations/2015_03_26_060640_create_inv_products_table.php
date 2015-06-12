<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('blurb');
            $table->text('description');
            $table->decimal('price_retail',10,2);
            $table->decimal('price_rep',10,2);
            $table->decimal('price_cv',10,2);
            $table->decimal('weight',10,2);
            $table->integer('volume');
            $table->string('sku',10,2);
            $table->integer('quantity');
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
		Schema::dropIfExists('products');
	}

}
