<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        DB::unprepared('
        CREATE TRIGGER TRobatkeluar AFTER INSERT ON obat_keluar FOR EACH ROW 
            BEGIN 
                UPDATE obat set stok = stok - new.jml_keluar where id_obat = new.id_obat;
            END 
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::unprepared('DROP TRIGGER TRobatkeluar');
    }
};
