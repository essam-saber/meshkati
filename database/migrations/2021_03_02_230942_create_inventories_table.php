<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('month');
            $table->decimal('goods_ready_for_sale', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('finished_products', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('semi_finished_products', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('work_in_process', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('raw_materials', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('spare_parts_and_others', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('inventory_provision', $precision = 10, $scale = 2)->default(0.00);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
