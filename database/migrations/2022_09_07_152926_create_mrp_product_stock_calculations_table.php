<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpProductStockCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_product_stock_calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_stock_logs');
            $table->bigInteger("inventory_product_list_id")->unsigned()->nullable();
            $table->foreign("inventory_product_list_id")->references("id")->on("mrp_inventory_product_list");
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
        Schema::dropIfExists('mrp_product_stock_calculations');
    }
}
