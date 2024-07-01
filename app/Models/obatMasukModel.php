<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class obatMasukModel extends Model
{
    use HasFactory;
    protected $table = 'obat_masuk';
    protected $primaryKey = 'id_masuk';
    protected $fillable = [
        'id_obat',
        'tgl_masuk',
        'jml_masuk',
        'harga_satuan',
        'total_harga',
    ];

    public function obat(): BelongsTo
    {
        return $this->belongsTo(obatModel::class, 'id_obat', 'id_obat', 'inner');
    }

    public $timestamps = false;
}
