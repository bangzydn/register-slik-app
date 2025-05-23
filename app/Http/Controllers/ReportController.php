<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Exports\ReportExports;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();
        $query = Report::query();
        // Ambil daftar kantor unik untuk dropdown filter
        $statusList = Report::select('status_slik')->distinct()->pluck('status_slik');

        // Filter hanya jika user memilih kantor
        if ($request->filled('status_slik')) {
            $query->where('status_slik', $request->status_slik);
        }

        // Ambil data paginated
        $reports = $query->paginate(1);

        return view('reports.index', compact('reports', 'statusList', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_nasabah' => 'required|string|max:255',
            'alamat_nasbah' => 'required|string|max:255',
            'status_slik' => 'required|string|max:255',
            'id_user' => 'required|string|max:255',
            'file_hasil' => 'nullable', // max 2MB
        ]);
       if ($request->file('file_hasil')) {
        // Ambil file dan simpan dengan nama menggunakan ID sementara
        $file = $request->file('file_hasil');
        $fileExtension = $file->getClientOriginalExtension();
        // Simpan sementara dengan ID mobil (belum ada ID saat pembuatan)
        $fileName = 'temp_' . uniqid() . '.' . $fileExtension;
        $filePath = $file->storeAs('file_hasil', $fileName, 'public');
    }
        Report::create([
            'nama_nasabah' => $request->nama_nasabah,
            'alamat_nasbah' => $request->alamat_nasbah,
            'status_slik' => $request->status_slik,
            'id_user' => $request->id_user,
            'file_hasil' => $filePath,
        ]);
        return redirect()->back()->with([
            'success' => 'Register berhasil ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

     public function export(Request $request)
    {
       $status_slik = $request->input('status_slik'); // bisa null

        // Tentukan nama file
        $fileName = $status_slik ? 'ReportSLIK_' . str_replace(' ', '_', $status_slik) . '.xlsx' : 'ReportSLIK_All.xlsx';

        return Excel::download(new ReportExports($status_slik), $fileName);
    }
}
