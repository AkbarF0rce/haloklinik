<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'kategori';
    public function up(): void
    {
        // 
        Schema::create($this->table, function(Blueprint $table){
            $table->integer('id_kategori', true, false)->nullable(false);
            $table->string('nama_kategori', 30)->nullable(false);
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
