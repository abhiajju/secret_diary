<?php
	session_start();

	if(array_key_exists("logout", $_GET)) {
		unset($_SESSION);
		session_destroy();
		session_start();
	}

	else if(array_key_exists("id", $_SESSION) AND $_SESSION["id"]) {
		header("Location: login.php");
	}

	if(array_key_exists("submit", $_POST)) {

		$err="";
		$p="";

		include("connection.php");

		if(!$_POST['email']) {
			$err.="An email address is required";
		}

		if(!$_POST['password']) {
			$err.="<br> A password address is required";
		}

		if($err!="")
			$err = "<p> Your form had some errors :</p> <br>".$err;

		else {

			$em=mysqli_real_escape_string($link, $_POST['email']);
			$pa=mysqli_real_escape_string($link, $_POST['password']);

			if($_POST['signup']=='1') {

				$query="SELECT id FROM diary WHERE email = '$em'";
				$result=mysqli_query($link, $query);
				if(mysqli_num_rows($result)>0) {
					$err.="THE EMAIL HAS BEEN TAKEN";
				}

				else {
					$query="INSERT INTO diary (email, password) VALUES ('$em', '$pa')";
					if(mysqli_query($link,$query)) {
						$iid=mysqli_insert_id($link);
						$encp=md5(md5($iid).$pa);
						$query = "UPDATE diary SET password = '$encp' WHERE id ='$iid'";
						mysqli_query($link,$query);
						if($_POST['stay_logged_in']=='1') {
							$_SESSION['id']=$iid;
							header("Location: login.php");
						}
						else {
							$p="Sign Up Successful";
						}
					}
				}
			}

			else {

				$query="SELECT * FROM diary WHERE email = '$em'";
				$result=mysqli_query($link, $query);
				$row=mysqli_fetch_array($result);
				if(array_key_exists("id", $row)) {
					
					$iid=$row['id'];
					
					$hashPass=md5(md5($iid).$_POST['password']);
					
					if($row["password"]==$hashPass) {
						$_SESSION["id"]=$iid;
						header("Location: login.php");
					}
					else {
						$err= "<p> Your form had some errors :</p> <br>"."your password is incorrect <br>";
					}
				}
				else {
					$err.= "Your email/password is incorrect";
				}
				
			}
		}
	}

?>


<?php include("header.php"); ?>
  
  	<div class="container">
	    <h1>Secret Diary</h1>
	    <div id="error">
			<?php if($err!="") {
				echo "<div class='alert alert-danger' role='alert'>".$err." </div>";		
				} 
				else if($p!="") {
					echo "<div class='alert alert-success' role='alert'>".$p." </div>";
				}
			?>
		</div>

		<h4> Store all your thoughts here </h4>

		<form method="POST" id="signupform"> 
			<p> Interested? Sign Up Now !! </p>
			<fieldset class="form-group">
				<input class="form-control" type="email" name="email" placeholder="Your Email">
			</fieldset>
			<fieldset class="form-group">
				<input class="form-control" type="password" name="password" placeholder="Password">
			</fieldset>
			<div class="form-check">
			    <label class="form-check-label">
			    	<input  type="checkbox" name="stay_logged_in" value='1' id="1"> Stay Logged In
			    </label>
			 </div>
			<fieldset class="form-group">
				<input type="hidden" name="signup" value="1">
				<input class="btn btn-success" type="submit" name="submit" value="Sign Up">
			</fieldset>
			<a href="#" class="toggle">Login</a>
		</form>

		<form method="POST" id="loginform"> 
			<p> Login with your email-id and password !! </p>
			<fieldset class="form-group">
				<input class="form-control" type="email" name="email" placeholder="Your Email">
			</fieldset>
			<fieldset class="form-group">
				<input class="form-control" type="password" name="password" placeholder="Password">
			</fieldset>
			<div class="form-check">
			    <label class="form-check-label">
			    	<input type="checkbox" name="stay_logged_in" value='1' id="0"> Stay Logged In
			    </label>
			 </div>
			<fieldset class="form-group">
				<input type="hidden" name="signup" value="0">
				<input class="btn btn-success" type="submit" name="submit" value="Login">
			</fieldset>
			<a href="#"class="toggle"> Sign Up </a>
		</form>
	</div>
    
    <?php include("footer.php"); ?>;


