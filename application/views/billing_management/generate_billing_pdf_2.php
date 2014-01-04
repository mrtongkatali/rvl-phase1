<?php

class MYPDF extends TCPDF {
        public function Header() {
            // Background color
            $this->Rect(0,0,210,297,'F','',$fill_color = array(216, 150, 100));
        }
    }

function createPDF($content) {

    // Extra header for background color
   
    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); // It only generates the first pdf document. Not the second.

    //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); // This line (with no custom header) works. It generates 2 pdf documents.

    // add a page
    $pdf->AddPage();

    $pdf->AddPage();

    $pdf->Write($h=0, $content, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);

    $folder = str_replace('//','/',$_SERVER['DOCUMENT_ROOT']."/documents/");
    $pdf->Output("TEST-".$content.'.pdf', 'D');



}

createPDF('1'); // This should create 1.pdf
createPDF('2'); // This should create 2.pdf
?>