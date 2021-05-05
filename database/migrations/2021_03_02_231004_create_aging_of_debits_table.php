<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgingOfDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aging_of_debits', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('month');
            $table->unsignedBigInteger('attribute_id');
            $table->decimal('value', $precision = 10, $scale = 2);
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
        Schema::dropIfExists('aging_of_debits');
    }
}
