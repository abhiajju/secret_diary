<?php
	session_start();
	$iid=$_SESSION['id'];
	if(array_key_exists("content",$_POST)) {
		include("connection.php");
		$contents=mysqli_real_escape_string($link,$_POST['content']);
		$query="UPDATE diary SET notes='$contents' WHERE id='$iid'";
		mysqli_query($link,$query);
	}
?>