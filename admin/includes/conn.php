<?php
    $conn = new mysqli('localhost', 'voting-system', 'Voting56=', 'voting-system');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>