<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class obatModel extends Model
{
    use HasFactory;
    protected $table = 'obat';
    protected $primaryKey = 'id_obat';
    protected $fillable = [
        'id_kategori',
        'kode_obat',
        'nama_obat',
        'harga',
        'stok',
        'foto'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(kategoriModel::class, 'id_kategori', 'id_kategori', 'inner');
    }

    public $timestamps = false;
}
