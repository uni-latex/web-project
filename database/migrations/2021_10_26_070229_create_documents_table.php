<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** ganti nama column
        alter table BC
        rename column ID to id,
         */

        /** transfer data
        insert into `web-latexindo`.documents (id, transaction_type, doc_type, doc_number, doc_date, vendor) select id, transaction_type, doc_type, doc_number, doc_date, vendor from BC
         */

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_type');
            $table->string('doc_type');
            $table->string('doc_number');
            $table->date('doc_date');
            $table->string('vendor');
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
        Schema::dropIfExists('documents');
    }
}
