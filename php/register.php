<?php
session_start();
?>
<?php  
	#phpinfo();
	$conn=mysqli_connect("localhost","root","","php");
	if(!$conn){
		die("Connection to DB Failed". mysqli_error() );
	}
#	else
#		echo "Successfully connnected to DB";


/*$sql="CREATE DATABASE php IF NOT EXISTS";
if(mysqli_query($conn,$sql)){
	echo "DB created";
}
else
	echo mysqli_error($conn);



	
/*$sql="CREATE TABLE user IF NOT EXISTS (id INT(6), fname VARCHAR(30), lname VARCHAR(30), uname VARCHAR(30), pass VARCHAR(30))";

#echo $sql;
if(mysqli_query($conn,$sql)){
	echo "Table created";
}
else
	echo mysqli_error($conn);
*/
if(isset($_REQUEST['register'])){
	$fname= $_REQUEST['fname'];
	$lname= $_REQUEST['lname'];
	$uname= $_REQUEST['uname'];
	$pass= $_REQUEST['pass'];
	echo $fname;
	#exit();
	$sql="INSERT into user(fname,lname,uname,pass) values('$fname','$lname','$uname','$pass')";
	
	if(mysqli_query($conn,$sql)){
		echo "Successfully Registered";
		
		
	}
	else
		mysqli_error();



}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" >
	<script src="js/bootstrap.min.js"></script>

</head>

<body>
	<div class="modal-dialog">
		<h2>Create a new Account</h2>
		<form method="post">
			<div class="form-group">
				<label for="fname">First Name</label>
				<input type="text" class="form-control" name="fname" id="fname" required>
			</div>
			<div class="form-group">
				<label for="lname">Last Name</label>
				<input type="text" class="form-control" name="lname" id="lname" required>
			</div>
			<div class="form-group">
				<label for="uname">Username</label>
				<input type="email" class="form-control" name="uname" id="uname" required>
			</div>
			<div class="form-group">
				<label for="pass">Password</label>
				<input type="password" class="form-control" name="pass" id="pass" required>
			</div>	
			<div class="form-group">
			<input type="submit" class="btn btn-dark" name="register" id="register" value="Register">
			</div>
	</form>
</div>
</body>
</html>