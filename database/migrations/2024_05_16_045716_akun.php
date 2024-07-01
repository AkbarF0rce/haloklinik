<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'akun';
    public function up(): void
    {
        //
        Schema::create($this->table, function(Blueprint $table){
            $table->integer('id_akun', true, false)->nullable(false);
            $table->string('username', 100)->nullable(false)->unique('IndexUsername');
            $table->string('password')->nullable(false);
            $table->enum('role', ['admin', 'dokter'])->nullable(false);
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
