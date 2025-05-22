<?php

namespace App\Http\Controllers;

use App\Models\Regslik;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class RegslikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $regsliks = Regslik::orderBy('created_at', 'DESC')->paginate(2);
        return view('regsliks.index')->with([
            'regsliks' => $regsliks,
            'users' => $users
        ]);
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
         $regsliks = [
            'kantor' => $request->input('kantor'),
            'nama_ao' => $request->input('nama_ao'),
            'nama_cadeb' => $request->input('nama_cadeb'),
            'alamat_cadeb' => $request->input('alamat_cadeb'),
            'sumber_berkas' => $request->input('sumber_berkas'),
            'supply_berkas' => $request->input('supply_berkas'),
            'sumber_supply' => $request->input('sumber_supply'),
            'plafond_pengajuan' => $request->input('plafond_pengajuan'),
            'status_cadeb' => $request->input('status_cadeb'),
            'usaha_cadeb' => $request->input('usaha_cadeb'),
            'id_user' => $request->input('id_user'),
        ];
         
        if ($request->hasFile('pernyataan_kesediaan') && $request->file('pernyataan_kesediaan')->isValid()) {
            // Store in storage/app/public/pernyataan_kesediaans or just storage/app/pernyataan_kesediaans
            $path = $request->file('pernyataan_kesediaan')->store('pernyataan_kesediaan', 'public');
            // $path contains the stored file path relative to the disk root (e.g. "pernyataan_kesediaans/xyz.jpg")

            $regsliks['pernyataan_kesediaan']=$path ;
            
        } else {
            return back()->withErrors(['pernyataan_kesediaan' => 'File upload failed.']);
        }
        Regslik::create($regsliks);
        return back()->with('success', 'Data Berhasil Ditambahkan!');
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
}
