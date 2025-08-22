<?php

namespace App;

use Smalot\PdfParser\Parser;

class PdfParser
{
    public function parse(string $filePath): array
    {
        $parser = new Parser();
        try {
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();
            
            // For simplicity, we'll treat the entire PDF content as a single document.
            // We'll put all the extracted text into the 'title' for full-text search
            // and add a placeholder for the year. A more advanced implementation
            // could try to extract these fields from the text.
            return [
                [
                    'id'    => uniqid('pdf_'), // Gera um ID único para o documento
                    'title' => $text,
                    'researcher_name' => 'Extraído de PDF', // Placeholder author
                    'year' => date('Y'), // Placeholder year
                    'type' => 'Documento PDF', // Placeholder type
                    'doi' => '' // PDFs might not have a DOI
                ]
            ];
        } catch (\Exception $e) {
            // Log error or handle it as needed
            error_log("Could not parse PDF: " . $e->getMessage());
            return [];
        }
    }
}
