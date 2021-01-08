<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->unsignedInteger('customer_id')->nullable();
            $table->string('name');
            $table->string('address');
            $table->Integer('phone');
            $table->string('email');
            $table->unsignedInteger('order_status');
            $table->unsignedInteger('payment_status')->nullable();
            $table->unsignedInteger('shipping_status')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')
                ->references('id')
                ->on('users');

            $table->foreign('order_status')
                ->references('id')
                ->on('statuses');

            $table->foreign('payment_status')
                ->references('id')
                ->on('statuses');

            $table->foreign('shipping_status')
                ->references('id')
                ->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
