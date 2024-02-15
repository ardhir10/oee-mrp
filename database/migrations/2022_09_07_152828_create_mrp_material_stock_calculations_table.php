<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpMaterialStockCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_material_stock_calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('material_stock_logs');
            $table->bigInteger("inventory_material_list_id")->unsigned()->nullable();
            $table->foreign("inventory_material_list_id")->references("id")->on("mrp_inventory_material_list");
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
        Schema::dropIfExists('mrp_material_stock_calculations');
    }
}
