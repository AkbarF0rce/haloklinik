<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class obatKeluarModel extends Model
{
    use HasFactory;
    protected $table = 'obat_keluar';
    protected $primaryKey = 'id_keluar';
    protected $fillable = [
        'id_obat',
        'tgl_keluar',
        'jml_keluar',
        'harga_satuan',
        'total_harga',
    ];

    public function obat(): BelongsTo
    {
        return $this->belongsTo(obatModel::class, 'id_obat', 'id_obat', 'inner');
    }

    public $timestamps = false;
}
