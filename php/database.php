<?php

	$db = new mysqli('localhost','peq','peq123','peq');

	// Check for errors
	if(mysqli_connect_errno()){
	 echo mysqli_connect_error();
	}

?>
