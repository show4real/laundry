<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->nullable();
            $table->integer('status')->nullable();
            $table->string('service_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('cloth_name')->nullable();
            $table->string('price')->nullable();
            $table->string('image_url')->nullable();
            $table->string('image_name')->nullable();
            $table->string('image_type')->nullable();
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
