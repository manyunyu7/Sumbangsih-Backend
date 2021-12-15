<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKTPIdentificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ktp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("name")->nullable();
            $table->string("birth_place")->nullable();
            $table->date("birth_date")->nullable();
            $table->string("nik")->nullable();
            $table->string("no_kk")->nullable();
            $table->string("jk")->nullable();
            $table->string("alamat")->nullable();
            $table->string("photo_requested")->nullable();
            $table->string("photo_face")->nullable();
            $table->string("photo_stored")->nullable();
            $table->string("verified_at")->nullable();
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
        Schema::dropIfExists('ktp');
    }
}
