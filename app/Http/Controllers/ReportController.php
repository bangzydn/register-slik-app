<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Exports\ReportExports;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        $reports = $query->paginate(2);

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
        'alamat_nasabah' => 'required|string|max:255',
        'status_slik' => 'required|in:Diterima,Ditolak',
        'id_user' => 'required|string|max:255',
        'file_hasil' => 'required|file|mimes:pdf|max:10240',
    ]);

    $filePath = null;
    
    if ($request->file('file_hasil')) {
        $file = $request->file('file_hasil');
        $originalName = $file->getClientOriginalName();
        $timestamp = now()->format('YmdHis');
        $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $fileName = $sanitizedName . '_' . $timestamp . '.pdf';
        $filePath = $file->storeAs('file_hasil', $fileName, 'public');
    }

    Report::create([
        'nama_nasabah' => $request->nama_nasabah,
        'alamat_nasabah' => $request->alamat_nasabah,
        'status_slik' => $request->status_slik,
        'id_user' => $request->id_user,
        'file_hasil' => $filePath,
    ]);

    return redirect()->back()->with('success', 'Laporan berhasil ditambahkan!');
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

    public function previewPdf(Request $request)
{
    $request->validate([
        'file_hasil' => 'required|file|mimes:pdf|max:10240',
    ]);

    $extractedData = ['nama_nasabah' => '', 'alamat_nasabah' => ''];

    if ($request->file('file_hasil')) {
        try {
            $file = $request->file('file_hasil');
            $tempPath = $file->store('temp');
            $fullPath = storage_path('app/' . $tempPath);

            if (class_exists('\Smalot\PdfParser\Parser')) {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($fullPath);
                $content = $pdf->getText();

                // Extract nama nasabah
                $extractedData['nama_nasabah'] = $this->extractNamaNasabah($content);
                
                // Extract alamat nasabah
                $extractedData['alamat_nasabah'] = $this->extractAlamatNasabah($content);

                // Clean up temp file
                Storage::delete($tempPath);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'PDF parser not installed. Run: composer require smalot/pdfparser'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error reading PDF: ' . $e->getMessage()
            ]);
        }
    }

    return response()->json([
        'success' => true,
        'data' => $extractedData
    ]);
}
private function extractNamaNasabah($content)
{
    // Common patterns for names in Indonesian documents
    $patterns = [
        '/nama[\s:]+([A-Z][a-zA-Z\s]{2,50})/i',
        '/name[\s:]+([A-Z][a-zA-Z\s]{2,50})/i',
        '/debitur[\s:]+([A-Z][a-zA-Z\s]{2,50})/i',
        '/nasabah[\s:]+([A-Z][a-zA-Z\s]{2,50})/i',
        '/pemohon[\s:]+([A-Z][a-zA-Z\s]{2,50})/i',
        '/applicant[\s:]+([A-Z][a-zA-Z\s]{2,50})/i',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content, $matches)) {
            $name = trim($matches[1]);
            // Clean up the name (remove extra spaces, numbers, special chars)
            $name = preg_replace('/[^a-zA-Z\s]/', '', $name);
            $name = preg_replace('/\s+/', ' ', $name);
            
            if (strlen($name) > 2 && strlen($name) < 50) {
                return $name;
            }
        }
    }

    return '';
}
private function extractAlamatNasabah($content)
{
    // Common patterns for addresses in Indonesian documents
    $patterns = [
        '/alamat[\s:]+([^\\n]{10,200})/i',
        '/address[\s:]+([^\\n]{10,200})/i',
        '/domisili[\s:]+([^\\n]{10,200})/i',
        '/tempat\s+tinggal[\s:]+([^\\n]{10,200})/i',
        '/residence[\s:]+([^\\n]{10,200})/i',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content, $matches)) {
            $address = trim($matches[1]);
            // Clean up the address
            $address = preg_replace('/\s+/', ' ', $address);
            $address = preg_replace('/[^\w\s,.\-\/]/', '', $address);
            
            if (strlen($address) > 10 && strlen($address) < 200) {
                return $address;
            }
        }
    }

    // Try to find address with common Indonesian terms
    $indonesianAddressPattern = '/(jl\.?|jalan|gang|gg\.?|rt\.?|rw\.?|kelurahan|kecamatan|kabupaten|kota)[^\\n]{5,150}/i';
    if (preg_match($indonesianAddressPattern, $content, $matches)) {
        $address = trim($matches[0]);
        $address = preg_replace('/\s+/', ' ', $address);
        
        if (strlen($address) > 10 && strlen($address) < 200) {
            return $address;
        }
    }

    return '';
}

}
