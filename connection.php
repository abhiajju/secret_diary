<?php
	$link=mysqli_connect("localhost","root","","secret");

		if(mysqli_connect_error()) {
			die("database connection error");
		}
?>