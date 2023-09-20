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
            $table->id();  
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->decimal('price',20);
            $table->decimal('item_total',20); 
            $table->enum('payment_status',['pending','failed','cancelled','success'])->nullable();
            $table->string('order_number')->nullable();
            $table->decimal('subtotal',20);
            $table->decimal('extra_amount',20);
            $table->decimal('total',20);
            $table->decimal('taxes',20);
            $table->string('shipping')->nullable();
            $table->enum('order_status',['dispatched','on the way','delivered','cancelled','pending', 'partial delivered']);
            $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
