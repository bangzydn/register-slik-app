<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use App\Models\Regslik;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Exports\RegslikExports;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Maatwebsite\Excel\Facades\Excel;

class RegslikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();
        $query = Regslik::query();

        // Ambil daftar kantor unik untuk dropdown filter
        $kantorList = Regslik::select('kantor')->distinct()->pluck('kantor');

        // Filter hanya jika user memilih kantor
        if ($request->filled('kantor')) {
            $query->where('kantor', $request->kantor);
        }

        // Ambil data paginated
        $regsliks = $query->paginate(2);

        return view('regsliks.index', compact('regsliks', 'kantorList', 'users'));
        
        
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
            'kantor' => 'required|string|max:255',
            'nama_ao' => 'required|string|max:255',
            'nama_cadeb' => 'required|string|max:255',
            'alamat_cadeb' => 'required|string|max:255',
            'sumber_berkas' => 'required|string|max:255',
            'supply_berkas' => 'required|string|max:255',
            'sumber_supply' => 'required|string|max:255',
            'plafond_pengajuan' => 'required|integer|min:255',
            'status_cadeb' => 'required|string|max:255',
            'usaha_cadeb' => 'required|string|max:255',
            'id_user' => 'required|string|max:255',
            'pernyataan_kesediaan' => 'nullable', // max 2MB
        ]);
       if ($request->file('pernyataan_kesediaan')) {
        // Ambil file dan simpan dengan nama menggunakan ID sementara
        $file = $request->file('pernyataan_kesediaan');
        $fileExtension = $file->getClientOriginalExtension();
        // Simpan sementara dengan ID mobil (belum ada ID saat pembuatan)
        $fileName = 'temp_' . uniqid() . '.' . $fileExtension;
        $filePath = $file->storeAs('regslik-pernyataan_kesediaan', $fileName, 'public');
    }
        Regslik::create([
            'kantor' => $request->kantor,
            'nama_ao' => $request->nama_ao,
            'nama_cadeb' => $request->nama_cadeb,
            'alamat_cadeb' => $request->alamat_cadeb,
            'sumber_berkas' => $request->sumber_berkas,
            'supply_berkas' => $request->supply_berkas,
            'sumber_supply' => $request->sumber_supply,
            'plafond_pengajuan' => $request->plafond_pengajuan,
            'status_cadeb' => $request->status_cadeb,
            'usaha_cadeb' => $request->usaha_cadeb,
            'id_user' => $request->id_user,
            'pernyataan_kesediaan' => $filePath,
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
        $request->validate([
            'kantor' => 'required|string|max:255',
            'nama_ao' => 'required|string|max:255',
            'nama_cadeb' => 'required|string|max:255',
            'alamat_cadeb' => 'required|string|max:255',
            'sumber_berkas' => 'required|string|max:255',
            'supply_berkas' => 'required|string|max:255',
            'sumber_supply' => 'required|string|max:255',
            'plafond_pengajuan' => 'required|integer|min:255',
            'status_cadeb' => 'required|string|max:255',
            'usaha_cadeb' => 'required|string|max:255',
            'id_user' => 'required|string|max:255',
            'pernyataan_kesediaan' => 'nullable', // max 2MB
        ]);
        
        $regslik = Regslik::findOrFail($id);
        $filePath = $regslik->pernyataan_kesediaan;

        // Handle file upload
        if ($request->hasFile('pernyataan_kesediaan') && $request->file('pernyataan_kesediaan')->isValid()) {
            $file = $request->file('pernyataan_kesediaan');
            $extension = $file->getClientOriginalExtension();
            $newFileName = $regslik->id . '.' . $extension;
            $newFilePath = 'pernyataan_kesediaan/' . $newFileName;

            // Delete old file if exists
            if ($regslik->pernyataan_kesediaan) {
                Storage::disk('public')->delete($regslik->pernyataan_kesediaan);
            }

            // Save new file
            $file->storeAs('pernyataan_kesediaan', $newFileName, 'public');
            $filePath = $newFilePath;
        }
       $regslik->update([
            'kantor' => $request->kantor,
            'nama_ao' => $request->nama_ao,
            'nama_cadeb' => $request->nama_cadeb,
            'alamat_cadeb' => $request->alamat_cadeb,
            'sumber_berkas' => $request->sumber_berkas,
            'supply_berkas' => $request->supply_berkas,
            'sumber_supply' => $request->sumber_supply,
            'plafond_pengajuan' => $request->plafond_pengajuan,
            'status_cadeb' => $request->status_cadeb,
            'usaha_cadeb' => $request->usaha_cadeb,
            'id_user' => $request->id_user,
            'pernyataan_kesediaan' => $filePath,
        ]);
        return redirect()->back()->with([
            'success' => 'Register berhasil diperbarui!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $regsliks = Regslik::findOrFail($id);
        $regsliks->delete();
        if ($regsliks->pernyataan_kesediaan) {
                Storage::disk('public')->delete($regsliks->pernyataan_kesediaan);
            }
        return back()->with('success', 'Data Berhasil dihapus!');
    }

    public function export(Request $request)
    {
       $kantor = $request->input('kantor'); // bisa null

        // Tentukan nama file
        $fileName = $kantor ? 'Regsliks_' . str_replace(' ', '_', $kantor) . '.xlsx' : 'Regsliks_All.xlsx';

        return Excel::download(new RegslikExports($kantor), $fileName);
    }
}
