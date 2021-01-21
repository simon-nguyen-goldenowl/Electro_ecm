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
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->unsignedInteger('cate_id');
            $table->unsignedInteger('brand_id');
            $table->string('image')->nullable();
            $table->integer('price');
            $table->integer('amount')->default(1);
            $table->integer('es_status')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cate_id')
                ->references('id')
                ->on('categories');

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands');
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
