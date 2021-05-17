<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained('shops')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('client_id');
            $table->string('address')->nullable();
            $table->string('sku');
            $table->float('amount');
            $table->float('advance_payment')->nullable();
            $table->text('notes')->nullable();
            $table->float('due_payment')->nullable();
            $table->text('websites')->nullable();
            $table->dateTime('next_payment_date')->nullable();
            $table->float('next_payment')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
