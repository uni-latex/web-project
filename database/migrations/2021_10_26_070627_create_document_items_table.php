<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** ganti nama column
        alter table BCItems
         */

        /** transfer data
        insert into `web-latexindo`.document_items (document_id, receipt_number, receipt_date, goods_code, goods_name_1, unit, quantity, valas, value, annotation_1, annotation_2) select document_id, receipt_number, receipt_date, goods_code, goods_name_1, unit, quantity, valas, value, annotation_1, annotation_2 from BCItems
         */

        Schema::create('document_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->string('receipt_number');
            $table->date('receipt_date');
            $table->string('goods_code');
            $table->string('goods_name_1')->nullable();
            $table->string('goods_name_2')->nullable();
            $table->string('unit');
            $table->float('quantity', 12, 2);
            $table->string('valas');
            $table->float('value', 12, 2);
            $table->text('annotation_1')->nullable();
            $table->text('annotation_2')->nullable();
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
        Schema::dropIfExists('document_items');
    }
}
