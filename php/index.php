<?php
session_start();

$conn=mysqli_connect("localhost","root","","php");
if(!$conn){
	die("Connection to DB Failed". mysqli_error() );
}
#else
#	echo "Successfully connnected to DB";

?>

<?php 
if(isset($_POST['login'])){
	$uname=$_POST['uname'];
	$pass=$_POST['pass'];
	
	$sql="SELECT uname,pass from user where uname='$uname' and pass='$pass'";

	$query=mysqli_query($conn,$sql);
	if($query){
		if(mysqli_num_rows($query)){
			$_SESSION['uname']=$uname;
			header("location: ./user.php");	
		}
		else{
			$error= "Username or Password doesn't match";
		}
		
	}
	else
		mysqli_error($conn);
}
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>
		Login Page
	</title>

<link rel="stylesheet" href="./bootstrap.min.css" >
</head>
<script>

<script src="./bootstrap.min.js">
	
</script>
<body>
	<div class=jumbotron>
		<h2>Login to Account</h2>
		<form method="post">
			<div class="form-group">
				<label for="uname">Username</label>
				<input type="email" class="form-control" name="uname" id="username" required>
				<button onclick="myFunction()">Check Uname</button>
				
				

			</div>
			
				

				

			<div class="form-group">
				<label for="pass">Password</label>
				<input type="password" class="form-control" name="pass" id="pass" required>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary" name="login" id=login>Login</button>
				<a href="register.php">Register as a new user</a>
			</div>
		</form>
						
		<h3><?php echo $error;?></h3>
	</div>

	
			

								<p id="demo">Hi..</p>

				
								<script>
								function myFunction() {
								    var x = document.getElementById("username").value;
								    document.getElementById("demo").innerHTML = x;
								}
								</script>

</body>
</html>