<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'obat';
    public function up(): void
    {
        //
        Schema::create($this->table, function(Blueprint $table){
            $table->integer('id_obat', true, false)->nullable(false);
            $table->integer('id_kategori', false, false)->index('idKategori')->nullable(false);
            $table->string('foto')->nullable(false);
            $table->string('kode_obat', 11)->nullable(false)->unique();
            $table->string('nama_obat', 100)->nullable(false);
            $table->integer('harga', false, false)->nullable(false);
            $table->integer('stok', false, false)->default(0)->nullable(false);
            // foreign key
            $table->foreign('id_kategori')->on('kategori')->references('id_kategori')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists($this->table);
    }
};
