<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduansTable extends Migration
{
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Added foreign key
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lampiran')->nullable();
            $table->string('nomor_tiket')->unique();
            $table->string('status')->default('Menunggu Tanggapan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduans');
    }
}
