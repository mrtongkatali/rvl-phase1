<?php

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
foreach($employee_payslip as $key=>$value):
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
$pdf->AddPage( 'P', 'LETTER');

	// Logo
	/*$image_file = BASE_FOLDER . 'themes/images/rvllogoonly.gif';
	$pdf->Image($image_file, 10, 10, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	$pdf->SetFont('helvetica', 'B', 14);
	$pdf->Cell(40, 8, 'RVL MOVERS CORPORATION', 0, 0, 'L', 0, '', 0, 1, 'T', 'B');
	
	$pdf->SetFont('helvetica', 'R', 10);
	$pdf->Cell(0, 8, date('m-d-Y'), 0, 1, 'R', 0, '', 0, 1, 'T', 'B');
	
	
	$pdf->SetX(45);
	$pdf->Cell(45, 0, '162 Vinalon St., Cupang, Muntinlupa City', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
	$pdf->SetX(45);
	$pdf->Cell(45, 0, 'Telephone 850-3066  Fax: 842-4747', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
	$pdf->SetX(45);
	$pdf->Cell(45, 0, 'TIN:  223-833-685-000-VAT', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
	
	$pdf->Ln(3);
	$pdf->Cell(0, 2, '', 'T', 1, 'L', 0, '', 0, 1, 'T', 'M');*/
	
	$pdf->SetFont('helvetica', 'B', 13);
	$pdf->Cell(0, 0, 'PAY SLIP', 0, 1, 'C', 0, '', 0, 0, 'T', 'M');
	$pdf->ln(5);

	$pdf->SetFont('helvetica', 'N', 10);
	
	$driver 	= $value['driver'];
	$pay_period = $value['pay_period'];
	
	$pdf->Cell(30, 5, 'Employee Name:', 0, 0, 'L', 0, '', 0, 1, 'T', 'M');
	$pdf->Cell(36, 5, $driver, "B", 0, 'L', 0, '', 0, 1, 'T', 'M');
	
	$pdf->Cell(35, 5, "", 0, 0, 'L', 0, '', 0, 1, 'T', 'M');
	
	$pdf->Cell(34, 5, 'Period of:', 0, 0, 'R', 0, '', 0, 1, 'T', 'M');
	$pdf->Cell(60, 5, $pay_period, "B", 1, 'L', 0, '', 0, 1, 'T', 'M');
	
	$pdf->Ln(10);
	
	$pdf->SetFont('helvetica', 'B', 10);
	
	$tw = array(49,	#0
				49,	#1
				49,	#2
				49,	#3
				);
		$pdf->Cell($tw[0] + $tw[1], 0, "EARNINGS", 'RTB', 0, 'C');
		//$pdf->Cell($tw[1], 0, "", 'LRTB', 0, 'C');
		$pdf->Cell($tw[0] + $tw[1], 0, "DEDUCTION", 'LTB', 0, 'C');
		$pdf->Ln();
		
	$pdf->SetFont('helvetica', 'R', 9);
	
		$basic_pay 	= number_format($value['gross_pay'],2,'.',',');
		$allowance 	= number_format(0,2,'.',',');
		$bonuses 	= number_format(0,2,'.',',');
		
		$tax 		= number_format($value['witholding'],2,'.',',');
		$philhealth = number_format($value['philhealth'],2,'.',',');
		$sss 		= number_format($value['pagibig'],2,'.',',');
		
		$deduction 	= number_format($value['total_deduction'],2,'.',',');
		$profit 	= number_format($value['gross_pay'],2,'.',',');

		$netpay 	= number_format($value['net_pay'],2,'.',',');
		
		$pdf->Cell($tw[0], 0, "Basic Pay", 'T', 0, 'L'); $pdf->Cell($tw[1], 0, $basic_pay, 'RT', 0, 'R');
		$pdf->Cell($tw[0], 0, "Tax (10%)", 'L', 0, 'L'); $pdf->Cell($tw[1], 0, $tax, '', 0, 'R');
		$pdf->Ln();
		$pdf->Cell($tw[0], 0, "Allowance", '', 0, 'L'); $pdf->Cell($tw[1], 0, $allowance, 'R', 0, 'R');
		$pdf->Cell($tw[0], 0, "Philhealth (1%)", 'L', 0, 'L');$pdf->Cell($tw[1], 0, $philhealth, '', 0, 'R');
		$pdf->Ln();
		
		$pdf->Cell($tw[0], 0, "Bonuses", 'B', 0, 'L'); $pdf->Cell($tw[1], 0, $bonuses, 'RB', 0, 'R');
		$pdf->Cell($tw[0], 0, "S.S.S (5%)", 'LB', 0, 'L');$pdf->Cell($tw[1], 0, $sss, 'B', 0, 'R');
		$pdf->Ln();
		
		// $pdf->Cell($tw[0], 0, "", 'LRTB', 0, 'L');$pdf->Cell($tw[1], 0, "", 'LRTB', 0, 'R');
		// $pdf->Cell($tw[0], 0, "", 'LRTB', 0, 'L');$pdf->Cell($tw[1], 0, "", 'LRTB', 0, 'R');
		// $pdf->Ln();
		// $pdf->Cell($tw[0], 0, "", 'LRTB', 0, 'L');$pdf->Cell($tw[1], 0, "", 'LRTB', 0, 'R');
		// $pdf->Cell($tw[0], 0, "", 'LRTB', 0, 'L');$pdf->Cell($tw[1], 0, "", 'LRTB', 0, 'R');
		// $pdf->Ln();
		
		// $pdf->Cell($tw[0], 0, "", 'LRTB', 0, 'L');$pdf->Cell($tw[1], 0, "", 'LRTB', 0, 'R');
		// $pdf->Cell($tw[0], 0, "", 'LRTB', 0, 'L');$pdf->Cell($tw[1], 0, "", 'LRTB', 0, 'R');
		// $pdf->Ln();
		$pdf->Ln(5);
		$pdf->Cell($tw[2], 0, "TOTAL EARNINGS", 'LTB', 0, 'L');$pdf->Cell($tw[3], 0, $profit, 'RTB', 0, 'R');
		$pdf->Cell($tw[2], 0, "TOTAL DETUCTION", 'LTB', 0, 'L');$pdf->Cell($tw[3], 0, $deduction, 'RTB', 0, 'R');
		
		$pdf->Ln(10);
		
		$pdf->Cell($tw[2], 0, "", '', 0, 'B');$pdf->Cell($tw[3], 0, "", ' ', 0, 'R');
		$pdf->SetFont('helvetica', 'B', '10');
		$pdf->Cell($tw[2], 0, "NET PAY", '', 0, 'L');$pdf->Cell($tw[3], 0, $netpay , '', 0, 'R');
		
		$pdf->Ln();
	
	
	$pdf->SetFont('helvetica', 'R', 9);
	$pdf->Ln();
	$pdf->SetX(107);
	$pdf->Cell(32, 5, 'Employee Signature:', 0, 0, 'L', 0, '', 0, 1, 'T', 'M');
	$pdf->Cell(60, 5, "", "B", 1, 'L', 0, '', 0, 1, 'T', 'M');
	
// reset pointer to the last page
$pdf->lastPage();
endforeach;
//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');

?>