<?php
	include 'includes/session.php';

	function generateRow($conn){
		$contents = '';
	 	
		
        	$contents .= '
        		<tr>
        		    <th width="5%"><b>S/No</b></th>
        			<th width="35%"><b>First Name</b></th>
        			<th width="10%"><b>LastName</b></th>
        			<th width="20%"><b>hashname</b></th>
        			<th width="30%"><b>Phone Number</b></th>
					<th width="30%"><b>Blood Group</b></th>
					
        			
        		</tr>
        	';
        	$counter = 0;
        	$sql = "SELECT * FROM registration ORDER BY firstname ASC";
                    $query = $conn->query($sql);
                    
                    while($row = $query->fetch_assoc()){
                     $count+=1;    
                      $contents .= "
                        <tr>
                          <td>".$count."</td>    
                          <td>".$row['firstname']."</td>
                          <td>".$row['lastname']."</td>
                          <td>".$row['hashname']."</td>
                          <td>".$row['phoneno']."</td>
						  <td>".$row['bloodgroup']."</td>
                         
                        </tr>
                      ";
                    }

        	


		return $contents;
	}
		
	$parse = parse_ini_file('config.ini', FALSE, INI_SCANNER_RAW);
    $title = $parse['election_title'];

	require_once('../tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Result: '.$title);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
      	<h2 align="center">'.$title.'</h2>
      	<h4 align="center">List of Hashers</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
      ';  
   	$content .= generateRow($conn);  
    $content .= '</table>';  
    $pdf->writeHTML($content);  
    $pdf->Output('AH3.pdf', 'I');

?>