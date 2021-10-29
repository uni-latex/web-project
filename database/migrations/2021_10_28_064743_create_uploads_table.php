<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // document / mutation
            $table->string('file_model');
            $table->date('file_date')->nullable();
            $table->string('original_file');
            $table->integer('file_size');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->boolean('is_success')->default(false);
            $table->text('exception')->nullable();
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
        Schema::dropIfExists('uploads');
    }
}
