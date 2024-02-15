<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProductOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_product_out', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('status')->nullable();
            $table->text('pic');
            $table->bigInteger("machine_id")->unsigned()->nullable();
            $table->bigInteger("product_id")->unsigned()->nullable();
            $table->bigInteger("shift_id")->unsigned()->nullable();
            
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");
            $table->foreign("product_id")->references("id")->on("mrp_products");
            $table->foreign("machine_id")->references("id")->on("oee_machines");
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
        Schema::dropIfExists('detail_product_out');
    }
}
