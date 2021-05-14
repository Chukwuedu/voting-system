<?php
	include 'includes/session.php';

	function generateRow($conn){
		$contents = '';
	 	
		
        	$contents .= '
        		<tr>
        		    
        			<td><b>Position</b></td>
        			<td><b>Candidate</b></td>
        			<td><b>Voter</b></td>
        			
        			
        		</tr>
        	';
        	
        	
                    $sql = "SELECT *, candidates.firstname AS canfirst, candidates.lastname AS canlast, voters.firstname AS votfirst FROM votes LEFT JOIN positions ON positions.id=votes.position_id LEFT JOIN candidates ON candidates.id=votes.candidate_id LEFT JOIN voters ON voters.id=votes.voters_id ORDER BY positions.priority, candidates.lastname ASC ";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      $contents .= "
                        <tr>
                          
                          <td>".$row['description']."</td>
                          <td>".$row['canfirst'].' '.$row['canlast']."</td>
                          <td>".$row['votfirst']."</td>
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
      	<h4 align="center">Votes</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
      ';  
   	$content .= generateRow($conn);  
    $content .= '</table>';  
    $pdf->writeHTML($content);  
    $pdf->Output('votes.pdf', 'I');

?>