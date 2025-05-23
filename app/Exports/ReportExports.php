<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportExports implements FromCollection, WithHeadings
{
    protected $status_slik;

    public function __construct($status_slik = null)
    {
        $this->status_slik = $status_slik;
    }

    public function collection()
    {
        $query = Report::select(
            "id", "nama_nasabah", "alamat_nasabah","status_slik", "id_user"
        );

        if ($this->status_slik) {
            $query->where('status_slik', $this->status_slik);
        }

        return $query->get();
    }

    
    
    public function headings(): array
    {
        return ["Id", "Nama Nasabah","Alamat Nasabah",
        "Status","Dibuat oleh"];
    }
}