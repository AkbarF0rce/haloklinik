<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'obat_masuk';
    public function up(): void
    {
        //
        Schema::create($this->table, function(Blueprint $table){
            $table->integer('id_masuk', true, false)->nullable(false);
            $table->integer('id_obat', false, false)->index('idObat')->nullable(false);
            $table->date('tgl_masuk', 0)->nullable(false);
            $table->integer('jml_masuk', false,false)->nullable(false);
            $table->integer('harga_satuan', false, false)->nullable(false);
            $table->integer('total_harga', false, false)->default(0)->nullable(false);
            // foreign key
            $table->foreign('id_obat')->on('obat')->references('id_obat')->onDelete('cascade')->onUpdate('cascade');
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
