namespace App\Services;

use Smalot\PdfParser\Parser;
use Exception;

class PdfReaderService
{
    private $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    public function readPdfFile($filePath)
    {
        try {
            $pdf = $this->parser->parseFile($filePath);
            
            return [
                'success' => true,
                'text' => $pdf->getText(),
                'details' => $pdf->getDetails(),
                'pages' => $pdf->getPages(),
                'page_count' => count($pdf->getPages())
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function extractPageTexts($pages)
    {
        $pageTexts = [];
        foreach ($pages as $pageNumber => $page) {
            $pageTexts[$pageNumber + 1] = $page->getText();
        }
        return $pageTexts;
    }
}