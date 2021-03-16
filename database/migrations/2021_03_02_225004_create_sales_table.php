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
            $table->string('year')->index();
            $table->string('month')->index();
            $table->decimal('cash')->default(0.00);
            $table->decimal('credit')->default(0.00);
            $table->decimal('returns')->default(0.00);
            $table->decimal('cost_of_sales')->default(0.00);;
            $table->decimal('expenses')->default(0.00);;
            $table->decimal('total')->default(0.00);
            $table->decimal('net_sales')->default(0.00);
            $table->decimal('net_sales_cum')->default(0.00);
            $table->decimal('gross_profit')->default(0.00);
            $table->decimal('gross_profit_cum')->default(0.00);
            $table->decimal('gross_profit_percentage')->nullable();
            $table->decimal('gross_profit_cum_percentage')->nullable();
            $table->decimal('net_profit')->default(0.00);
            $table->decimal('net_profit_cum')->default(0.00);
            $table->decimal('net_profit_percentage')->nullable();
            $table->decimal('net_profit_cum_percentage')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
