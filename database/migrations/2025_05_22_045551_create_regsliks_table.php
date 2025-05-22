<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regsliks', function (Blueprint $table) {
            $table->id();
            $table->string('pernyataan_kesediaan');
            $table->string('kantor');
            $table->string('nama_ao');
            $table->string('nama_cadeb');
            $table->string('alamat_cadeb');
            $table->string('sumber_berkas');
            $table->string('supply_berkas');
            $table->string('sumber_supply');
            $table->integer('plafond_pengajuan');
            $table->string('status_cadeb');
            $table->string('usaha_cadeb');
            $table->string('id_user');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regsliks');
    }
};
