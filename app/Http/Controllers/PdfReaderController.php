<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Exception;

class PdfReaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [
            'text' => null,
            'details' => null,
            'pageCount' => null,
            'pageTexts' => null,
            'fileName' => null,
            'userName' => null
        ];

        // Check if form was submitted
        if ($request->hasFile('pdf_file')) {
            // Validate the uploaded file and name
            $request->validate([
                'user_name' => 'required|string|max:255|min:2',
                'pdf_file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            ]);

            try {
                // Get the uploaded file
                $file = $request->file('pdf_file');
                
                // Initialize PDF parser
                $parser = new Parser();
                
                // Parse the PDF file
                $pdf = $parser->parseFile($file->getPathname());
                
                // Extract text content
                $text = $pdf->getText();
                
                // Get PDF metadata
                $details = $pdf->getDetails();
                
                // Get number of pages
                $pages = $pdf->getPages();
                $pageCount = count($pages);
                
                // Extract text from each page separately
                $pageTexts = [];
                foreach ($pages as $pageNumber => $page) {
                    $pageTexts[$pageNumber + 1] = $page->getText();
                }
                
                $data = [
                    'text' => $text,
                    'details' => $details,
                    'pageCount' => $pageCount,
                    'pageTexts' => $pageTexts,
                    'fileName' => $file->getClientOriginalName(),
                    'userName' => $request->input('user_name')
                ];
                
            } catch (Exception $e) {
                return back()->withErrors(['error' => 'Error reading PDF: ' . $e->getMessage()]);
            }
        }

        return view('pdf-reader.index', $data);
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
        //
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
