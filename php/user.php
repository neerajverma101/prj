<?php
session_start();
$conn=mysqli_connect("localhost","root","","php");
	if(!$conn){
		die("Connection to DB Failed". mysqli_error() );
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
<link rel="stylesheet" href="./bootstrap.min.css" >
</head>
<script>

<script src="./bootstrap.min.js">
	
</script>
<body>
	<div class="container">
		<h2>My Account</h2>
	</div>
	<div class="jumbotron">
		<?php
		echo "Welcome!!!". " ". $_SESSION['uname'];
		?>
	</div>
	<div>
		<?php
		$uname=$_SESSION['uname'];
		$sql="SELECT fname,lname from user where uname='$uname'";
		$query=mysqli_query($conn,$sql);

		if($query){
		$row=mysqli_fetch_array($query);
		echo "Your full name is". $row['fname'].$row['lname'];
		}
		else{
			echo mysqli_error($conn);
		}
		?>
	</div>
	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="images">Select image to upload</label>
			<input type="file" name="images">
			
		</div>
		<button type="submit" class="btn btn-primary" name="upload">Upload Pic</button> 
	</form>

<?php
if(isset($_POST['upload'])){
	$desti_folder="./uploads/";
	$target_file=$desti_folder.basename($_FILES['images']['name']);

	if(move_uploaded_file($_FILES['images']['tmp_name'], $target_file)){
		
		$sql="ALTER TABLE user ADD IF NOT EXISTS images varchar(255)";
		#echo $target_file;
		$uname=$_SESSION['uname'];
		#echo $uname;
		$sql2="UPDATE user SET images='$target_file' where uname='$uname'";

		$query=mysqli_query($conn,$sql);
		$query2=mysqli_query($conn,$sql2);
		if($query2){
			echo "Updated successfully";
		}
		else{
			echo mysqli_error($conn);
		}

		
	}
	else{
		echo "Couldn't Upload";
	}
}
?>

<div>
	<form method="post">
		<input type="submit" class="form-control" name="view" value="View Profile">	
	</form>
	<?php
		if(isset($_POST['view'])){
			$uname=$_SESSION['uname'];
			$sql="SELECT fname,lname,uname,images from user where uname='$uname'";
			$query=mysqli_query($conn,$sql);
			$row;
			$row=mysqli_fetch_array($query,MYSQLI_ASSOC);

	?>
		<h3>Full Name: <?php echo $row['fname']." ".$row['lname']; ?> </h3>
		
		<h3>User Name: <?php echo $row['uname']; ?> </h3>
		<img src="<?php echo $row['images']; ?>" width="200px">
		
		<?php
		}
	?>
		

</div>
</body>
</html>