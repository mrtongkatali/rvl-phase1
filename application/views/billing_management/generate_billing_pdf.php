<?php
// create new PDF document

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = BASE_FOLDER.'themes/images/rvllogoonly.gif';
        $this->Image($image_file, 10, 10, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		//Cell ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
        $this->SetFont('helvetica', 'B', 14);
		$this->Cell(40, 8, 'RVL MOVERS CORPORATION', 0, 1, 'L', 0, '', 0, 1, 'T', 'B');
		
		$this->SetFont('helvetica', 'R', 8);
        
		$this->SetX(45);
		$this->Cell(45, 0, '162 Vinalon St., Cupang, Muntinlupa City', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
		$this->SetX(45);
		$this->Cell(45, 0, 'Telephone 850-3066  Fax: 842-4747', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
		$this->SetX(45);
		$this->Cell(45, 0, 'TIN:  223-833-685-000-VAT', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
				
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RVL Movers');
$pdf->SetTitle('Billing');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');


// remove default header/footer
$pdf->setPrintHeader(false);
#$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, 5, 10);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table
// add a page

foreach($billing_data as $key=>$value):
	$pdf->AddPage( 'L', 'LETTER');
	#debug_array($value);

		// Logo
		$image_file = BASE_FOLDER.'themes/images/rvllogoonly.gif';
		$pdf->Image($image_file, 10, 10, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$pdf->SetFont('helvetica', 'B', 14);
		$pdf->Cell(40, 8, 'RVL MOVERS CORPORATION', 0, 1, 'L', 0, '', 0, 1, 'T', 'B');
		
		$pdf->SetFont('helvetica', 'R', 8);
		
		$pdf->SetX(45);
		$pdf->Cell(45, 0, '162 Vinalon St., Cupang, Muntinlupa City', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
		$pdf->SetX(45);
		$pdf->Cell(45, 0, 'Telephone 850-3066  Fax: 842-4747', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
		$pdf->SetX(45);
		$pdf->Cell(45, 0, 'TIN:  223-833-685-000-VAT', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
		
		$pdf->Ln(3);
		$pdf->Cell(0, 10, '', 'T', 1, 'L', 0, '', 0, 1, 'T', 'M');
		
		$pdf->SetY(34);

		$pdf->SetFont('helvetica', 'B', 12);
		
		$clientName = "client name";
		$clientAddress = "client address";
		$datePrepared = "October 20, 2013";
		
		$pdf->Cell(20, 5, 'BILL TO: ', 0, 0, 'L', 0, '', 0, 1, 'T', 'M');
		$pdf->Cell(160, 5, $value['bill_to'], 0, 0, 'L', 0, '', 0, 1, 'T', 'M');
		//$pdf->Cell(0, 5, 'Date Prepared: '.$value['date_prepared'], 0, 0, 'R', 0, '', 0, 1, 'T', 'M');
		$pdf->Cell(0, 5, '', 0, 0, 'R', 0, '', 0, 1, 'T', 'M');
		$pdf->Ln();
		$pdf->Cell(20, 5, '', 0, 0, 'L', 0, '', 0, 0, 'T', 'M');
		$pdf->Cell(160, 5, $value['client_address'], 0, 0, 'L', 0, '', 0, 1, 'T', 'M');
		
		$pdf->Ln(10);
		
		$pdf->Cell(0, 0, 'STATEMENT OF ACCOUNT', 0, 1, 'C', 0, '', 0, 0, 'T', 'M');
		$pdf->Cell(0, 0, "CAR CARRIER SERVICES FOR PERIOD: {$date_coverage}", 0, 1, 'C', 0, '', 0, 0, 'T', 'M');
		
		$pdf->Ln(4);
		$pdf->SetFont('helvetica', 'B', 9);
		
		$tw = array(20,	#0
					22,	#1
					22,	#2
					42,	#3
					10,	#4
					42,	#5
					42,	#6
					20,	#7
					20,	#8
					19.5	#9
					);
			$pdf->Cell($tw[0] + $tw[1], 0, "DR No.", 'LRTB', 0, 'C');
			//$pdf->Cell($tw[1], 0, "Invoice Date", 'LRTB', 0, 'C');
			$pdf->Cell($tw[2], 0, "Delivery Date", 'LRTB', 0, 'C');
			$pdf->Cell($tw[3], 0, "Model", 'LRTB', 0, 'C');
			$pdf->Cell($tw[4], 0, "QTY", 'LRTB', 0, 'C');
			$pdf->Cell($tw[5], 0, "Pick-up Address", 'LRTB', 0, 'C');
			$pdf->Cell($tw[6], 0, "Delivery Address", 'LRTB', 0, 'C');
			$pdf->Cell($tw[7], 0, "Truck used", 'LRTB', 0, 'C');
			$pdf->Cell($tw[8], 0, "Trip Type", 'LRTB', 0, 'C');
			$pdf->Cell($tw[9], 0, "Charges", 'LRTB', 0, 'C');
			$pdf->Ln();
			
		$pdf->SetFont('helvetica', 'R', 9);

		$grand_total = 0;
		$total_units = 0;

		foreach($value['vn_list'] as $a=>$b):
			$pdf->Cell($tw[0] + $tw[1], 0, str_pad($b['dr_no'],10,"0",STR_PAD_LEFT), 'LRTB', 0, 'C');
			//$pdf->Cell($tw[1], 0, $b['invoice_date'], 'LRTB', 0, 'C');
			$pdf->Cell($tw[2], 0, $b['delivery_date'], 'LRTB', 0, 'C');
			$pdf->Cell($tw[3], 0, $b['model'], 'LRTB', 0, 'C');
			$pdf->Cell($tw[4], 0, $b['qty'], 'LRTB', 0, 'C');
			$pdf->Cell($tw[5], 0, $b['pickup_address'], 'LRTB', 0, 'C');
			$pdf->Cell($tw[6], 0, $b['delivery_address'], 'LRTB', 0, 'C');
			$pdf->Cell($tw[7], 0, $b['truck_used'], 'LRTB', 0, 'C');
			$pdf->Cell($tw[8], 0, $b['trip_type'], 'LRTB', 0, 'C');
			$pdf->Cell($tw[9], 0, number_format($b['charges'], 2, '.', ','), 'LRTB', 0, 'R');
			$pdf->Ln();

			$grand_total += $b['charges'];
			$total_units += $b['qty'];
			
		endforeach;
		
		$eVAT = 0.0;
		$totalCharges = 0.0;
		$pdf->Ln(2);
		$pdf->Cell(0, 0, "", 'T', 0, 'R');
		$pdf->Ln(2);
		$pdf->SetFont('helvetica', 'B', 9);
		$pdf->Cell(array_sum($tw)-($tw[9]+$tw[8]+$tw[7]+$tw[6]+$tw[5]+$tw[4]), 0, "TOTAL UNITS DELIVERED", 0, 0, 'R');
		$pdf->Cell($tw[4], 0, $total_units, 'LRTB', 0, 'C');
		$pdf->Cell($tw[5], 0, "", 0, 0, 'R');
		$pdf->Cell($tw[8] + $tw[7] + $tw[6], 0, "TOTAL OF CHARGES", "LTR", 0, 'L');
		$pdf->Cell($tw[9], 0, $totalCharges, "LTRB", 1, 'R');
		
		$pdf->Cell(array_sum($tw)-($tw[9]+$tw[8]+$tw[7]+$tw[6]+$tw[5]+$tw[4]), 0, "TOTAL NUMBER OF TRIP  ", 0, 0, 'R');
		$pdf->Cell($tw[4], 0, "00", 'LRTB', 0, 'C');
		$pdf->Cell($tw[5], 0, "", 0, 0, 'R');
		$pdf->Cell($tw[8] + $tw[7] + $tw[6], 0, "12% E-VAT", "L", 0, 'L');
		$pdf->Cell($tw[9], 0, $eVAT, "LR", 1, 'R');
		
		$pdf->Cell(array_sum($tw)-($tw[9]+$tw[8]+$tw[7]+$tw[6]+$tw[5]+$tw[4]), 0, "", 0, 0, 'L');
		$pdf->Cell($tw[5] + $tw[4], 0, "", 0, 0, 'R');
		$pdf->Cell($tw[8] + $tw[7] + $tw[6], 0, "GRAND TOTAL VAT-INCLUSIVE", "LTBR", 0, 'L');
		$pdf->Cell($tw[9], 0, number_format($grand_total,2,',','.'), "LRTB", 0, 'R');
		$pdf->Ln();	

	// reset pointer to the last page
	$pdf->lastPage();
endforeach;
//Close and output PDF document
$pdf->Output('example_006.pdf', 'D');

?>