<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Regslik;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegslikExports implements FromCollection, WithHeadings
{
    protected $kantor;

    public function __construct($kantor = null)
    {
        $this->kantor = $kantor;
    }

    public function collection()
    {
        $query = Regslik::select(
            "id", "kantor", "nama_ao",
            "nama_cadeb", "alamat_cadeb", "sumber_berkas", "supply_berkas", "sumber_supply",
            "plafond_pengajuan", "status_cadeb", "usaha_cadeb", "id_user", "created_at"
        );

        if ($this->kantor) {
            $query->where('kantor', $this->kantor);
        }

        return $query->get()->map(function ($regslik) {
            return [
                'id' => $regslik->id,
                'kantor' => $regslik->kantor,
                'nama_ao' => $regslik->nama_ao,
                'nama_cadeb' => $regslik->nama_cadeb,
                'alamat_cadeb' => $regslik->alamat_cadeb,
                'sumber_berkas' => $regslik->sumber_berkas,
                'supply_berkas' => $regslik->supply_berkas,
                'sumber_supply' => $regslik->sumber_supply,
                'plafond_pengajuan' => $regslik->plafond_pengajuan,
                'status_cadeb' => $regslik->status_cadeb,
                'usaha_cadeb' => $regslik->usaha_cadeb,
                'id_user' => $regslik->id_user,
                'created_at' => $regslik->created_at->format('j M Y'),
            ];
        });
    }

    
    
    public function headings(): array
    {
        return ["Id", "Kantor", "Account Officer",
        "Nama Calon Debitur","Alamat","Sumber Berkas","Supply Berkas",
        "Sumber Supply","Plafond Pengajuan",
        "Status","Usaha Calon Debitur","Dibuat oleh","Dibuat Pada"];
    }
}