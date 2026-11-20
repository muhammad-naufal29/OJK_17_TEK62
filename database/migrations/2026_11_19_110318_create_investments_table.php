
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('jenis_reksa_dana');
            $table->string('manajer_investasi');
            $table->date('tanggal_pembelian');
            $table->decimal('jumlah_unit', 15, 4);
            $table->decimal('harga_per_unit', 15, 2);
            $table->decimal('total_investasi', 20, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
