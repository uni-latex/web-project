<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutationBjTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** ganti nama column
        alter table MutasiBJ
        rename column ID to id,
        rename column GoodsCode to goods_code,
        rename column GoodsName to goods_name,
        rename column Unit to unit,
        rename column BeginningBalance to beginning_balance,
        rename column Entering to entering,
        rename column Spending to spending,
        rename column Compliance to compliance,
        rename column FinalBalance to final_balance,
        rename column StockOpname to stock_opname,
        rename column Difference to difference,
        rename COLUMN Annotation to annotation,
        rename COLUMN StartPeriod to mutation_date
         */

        /** transfer data
        insert into `web-latexindo`.mutation_bj (id, goods_code, goods_name, unit, beginning_balance, entering, spending, compliance, final_balance, stock_opname, difference, annotation, mutation_date) select id, goods_code, goods_name, unit, beginning_balance, entering, spending, compliance, final_balance, stock_opname, difference, annotation, mutation_date from MutasiBJ
         */

        Schema::create('mutation_bj', function (Blueprint $table) {
            $table->id();
            $table->date('mutation_date')->index();
            $table->string('goods_code')->index();
            $table->string('goods_name')->index();
            $table->string('unit')->nullable();
            $table->float('beginning_balance', 12, 2)->default(0);
            $table->float('entering', 12, 2)->default(0);
            $table->float('spending', 12, 2)->default(0);
            $table->float('compliance', 12, 2)->default(0);
            $table->float('final_balance', 12, 2)->default(0);
            $table->float('stock_opname', 12, 2)->default(0);
            $table->float('difference', 12, 2)->default(0);
            $table->text('annotation')->nullable();
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
        Schema::dropIfExists('mutation_bj');
    }
}
