<?php 
//db connection
$conn = new mysqli('localhost', 'root', '', 'test');	

require '../fpdf184/fpdf.php';
class PDF extends FPDF{
	function Header(){
		$this->SetY(2);
		// Select Arial bold 15
	    $this->SetFont('Times','B',14);
	    // Move to the right
	    $this->Cell(80);
	    // Framed title
	    $this->Cell(30,6,'EXAM SEAT ALLOCATION FOR: COSC001',0,0,'C');
	    // Line break
	    $this->Ln();

	    $this->Cell(80);
	    $this->SetFont('Times','B',12);
	    // Framed title
	    $this->Cell(30,6,'2021 Academic Session.',0,0,'C');	    
	    $this->Ln();
	}

	function Footer(){
		// Go to 1.5 cm from bottom
	    $this->SetY(-8);
	    // Select Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Print centered page number
	    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}
	function headerTable(){
		$this->SetFont("Times",'B',9);
		$this->Cell(8,5,'SN',1,0,'C');
		$this->Cell(30,5,'REG NO',1,0,'C');
		$this->Cell(40,5,'NAME',1,0,'C');
		$this->Cell(15,5,'SEAT NO',1,0,'C');
		$this->Cell(30,5,'ATTENDACE',1,0,'C');
	    $this->Ln();	    
	}

	function viewAllocation($conn){
		$this->SetFont('Times','',12);
		$sql = "SELECT v.regNo, v.courseCode, v.seatNo, c.courseTitle, cr.name\n"

		    . "FROM venueA v\n"

		    . "JOIN courses c\n"

		    . "ON v.courseCode = c.courseCode\n"

		    . "JOIN course_reg cr\n"

		    . "ON cr.regNo = v.regNo;";
		$result = $conn->query($sql);
		$i=1;
		while($row = mysqli_fetch_array($result)){
				$this->SetFont("Times",'',10);
				$this->Cell(8,5,$i,1,0,'C');
				$this->Cell(30,5,$row['regNo'],1,0,'L');
				$this->Cell(40,5,$row['name'],1,0,'L');
				$this->Cell(15,5,$row['seatNo'],1,0,'C');
				$this->Cell(30,5,'',1,0,'C');
			    $this->Ln();
			    $i++;		
		}
	}


}
$pdf = new PDF();
$pdf->SetTitle("SEAT ALLOCATION TEMPLATE");
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewAllocation($conn);
$pdf->Output();

 ?>