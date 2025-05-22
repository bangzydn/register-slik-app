<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regslik extends Model
{
    protected $fillable = [
        'pernyataan_kesediaan',
        'kantor',
        'nama_ao',
        'nama_cadeb',
        'alamat_cadeb',
        'sumber_berkas',
        'supply_berkas',
        'sumber_supply',
        'plafond_pengajuan',
        'status_cadeb',
        'usaha_cadeb',
        'id_user'
    ];

     public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
