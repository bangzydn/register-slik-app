<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
     protected $fillable = [
        'file_hasil',
        'nama_nasabah',
        'alamat_nasabah',
        'status_slik',
        'id_user'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
