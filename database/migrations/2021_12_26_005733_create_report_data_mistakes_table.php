<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportDataMistakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_data_mistakes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("name")->nullable();
            $table->string("birth_place")->nullable();
            $table->date("birth_date")->nullable();
            $table->string("nik")->nullable();
            $table->string("no_kk")->nullable();
            $table->string("jk")->nullable();
            $table->string("contact")->nullable();
            $table->string("alamat")->nullable();
            $table->string("fixed_at")->nullable();
            $table->string("fixed_status")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('report_data_mistakes');
    }
}
