<?php
	
	session_start();
	if(array_key_exists('id', $_SESSION)) {

		include("connection.php");

		
		//$em=mysqli_real_escape_string($link, $_POST['email']);
		//$pa=mysqli_real_escape_string($link, $_POST['password']);
		$iid=$_SESSION['id'];
		$query="SELECT * FROM diary WHERE id = '$iid'";
		$result=mysqli_query($link, $query);
		if(mysqli_num_rows($result)>0) {
			$row = mysqli_fetch_row($result);
		}
		else {
			echo "Some problem";
		}


	}

	include("header.php"); 
?>

	
	<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
	<a class="navbar-brand" href="#">Secret Diary</a>
	 	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    	<span class="navbar-toggler-icon"></span>
	  	</button>

	  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    	<ul class="navbar-nav mr-auto">
	      		<li class="nav-item active">
	        		<a class="nav-link" href="#">Welcome <?php echo $row[1]; ?> <span class="sr-only">(current)</span></a>
	      		</li>
	      		<li class="nav-item">
	        		<a class="nav-link" id='logoutid' href="index.php?logout=1">Log Out</a>
	      		</li>
	      	</ul>
	  	</div>
	</nav>
	<div class="container-fluid"> 
		<textarea class="form-control" rows="20" id="notes"><?php echo $row[3] ?></textarea>
	</div>

<?php include("footer.php");  ?>

	
