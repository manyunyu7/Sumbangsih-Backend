<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanSKUSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_s_k_u_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("event_id")->nullable();
            $table->string("lat_selfie")->nullable();
            $table->string("long_selfie")->nullable();
            $table->string("lat_usaha")->nullable();
            $table->string("long_usaha")->nullable();
            $table->string("nama_usaha")->nullable();
            $table->string("photo_ktp")->nullable();
            $table->string("photo_usaha")->nullable();
            $table->string("photo_selfie")->nullable();
            $table->foreign("event_id")->references("id")->on("bansos_events")->onDelete("cascade");
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
        Schema::dropIfExists('pengajuan_s_k_u_s');
    }
}
