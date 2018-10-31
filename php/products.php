<?php
$conn=mysqli_connect('localhost','root','','php')
?>


<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
<link rel="stylesheet" href="./css/bootstrap.min.css" >
<script src="./js/jquery-3.3.1.min.js"></script>

<script src="./js/bootstrap.min.js"></script>

</head>

<body class="jumbotron">
	<div>
		<h2>Add Products</h2>
		<form method="post" enctype="multipart/form-data">
			<label for="pname">Products Name</label>
			<input type="text" name="pname">
			<label for="pimage">Product Image</label>
			<input type="file" name="pimage">
			<label for="pquantity">Quantity</label>
			<input type="text" name="pquantity">
			<input type="submit" name="psubmit" value="Add Product">
		</form>
	</div>	
	<!-- Add Product Code-->
	<?php
		if(isset($_POST['psubmit'])){
			//$target_folder="./uploads/products";
			//$target_file=$target_folder.basename($_FILES['pimage']['name']);
			$target_dir = "./uploads/products/";
			$target_file = $target_dir . basename($_FILES["pimage"]["name"]);
			if(move_uploaded_file($_FILES['pimage']['tmp_name'], $target_file)){


				$pname=$_POST['pname'];
				$pimage=$target_file;
				$pquantity=$_POST['pquantity'];
				$sql="INSERT into products(pname,pimage,pquantity) values('$pname','$pimage','$pquantity')";
				$query=mysqli_query($conn,$sql); 
				if($query){
					echo "Product Added Successfully";
				}
				else{
					echo mysqli_error($conn);
				}
			}	
		}

	?>

<!-- View Product -->
	<div>
		<form method="post">
			<input type="submit" name="vproducts" value="View Products">
		</form>
	</div>
<!-- View Product Code -->
	<?php
	if(isset($_POST['vproducts'])){
		$sql="SELECT id,pname,pimage,pquantity from products";
		$query=mysqli_query($conn,$sql);
		if($query){
			echo "Following are the records:";
		}
		else{
			echo mysqli_error($conn);
		}
	?>

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Product Name </th>
				<th>Product Image </th>
				<th>Product Quantity</th>
			</tr>
		</thead>
		<tbody>
			<!-- Loop to View Product-->
			<?php
			$i = 1;
				while ($row = mysqli_fetch_assoc($query)) {
					?>
					<tr>
						<td><?php echo $row['pname'];?></td>
						<td><img src="<?php echo $row['pimage'];?>" width="100 px"</td>
						<td>
							<?php echo $row['pquantity'];?>
							
						</td>
						<td>
							<!-- Product Edit Modal Code-->
							<input type="submit" name="pedit" value="Edit" class="btn btn-primary" data-toggle="modal" data-target="#pmodal<?php echo $i?>">
							<div class="modal fade" id="pmodal<?php echo $i?>" role="dialog">
								<div class="modal-dilog">
									<div class="modal-content">
										<div class="modal-header">
											<div class="modal-title">
												<h3>Update Product</h3>
											</div>
											<button type="button" class="close" data-dismiss="modal">&#10060;</button>
										</div>
										<div class="modal-body">
											<table class="table table-striped table-hover">
												<thead>
													<tr>
														<th>Product Name </th>
														<th>Product Image </th>
														<th>Product Quantity</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<form method="post" enctype="multipart/form-data">
															<td><input type="text" name="pname" value="<?php echo $row['pname'];?>" required></td>
															<td>
																	<img src="<?php echo $row['pimage']; ?>" width="100px">
																	<input type="file" name="pimage">
															</td>
															<td><input type="text" name="pquantity" value="<?php echo $row['pquantity'];?>" required><input type="hidden" name="pid" value="<?php echo $row['id']; ?>"></td>
															<td><input type="submit" name="pupdate" value="Update Product"></td>
															<td><a href="">Cancel</a></td>
														</form>
													</tr>
												</tbody>
											</table>

										</div>
										<div class="modal-footer">
								          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        </div>
									</div>
								</div>
							</div>
							
						</td>
						<td>
							<form method='post'>
								<input type='hidden' value="<?php echo $row['id'];?>" name='pid'>
								<input type='submit' name='pdelete' value='Delete'>
							</form>
						</td>
					</tr>
			<?php 
			$i++;
				}
			?>
		</tbody>
	</table>
	<?php
	}
	?>

<!--Product Edit Code-->
	<?php
		if(isset($_POST['pedit'])){
			$pid=$_POST['pid'];
			$sql="SELECT pname,pimage,pquantity from products where id='$pid'";
			$query=mysqli_query($conn,$sql);
			if($query){
				$row=mysqli_fetch_array($query);
				$pname=$row['pname'];
				$pimage=$row['pimage'];
				$pquantity=$row['pquantity'];
			}
			else{
				echo mysqli_error($conn);
			}
		}
	?>	
	
<!-- Product Update code-->
	<?php
		if(isset($_POST['pupdate']) && $_FILES['pimage']['name']!=""){
			$pid=$_POST['pid'];
			$pname=$_POST['pname'];
			$pquantity=$_POST['pquantity'];
			$desti_folder="./uploads/";
			$target_file=$desti_folder.basename($_FILES['pimage']['name']);
			move_uploaded_file($_FILES['pimage']['tmp_name'], $target_file);
			$sql="UPDATE products SET pname='$pname',pimage='$target_file',pquantity='$pquantity' where id='$pid'";
			$query=mysqli_query($conn,$sql);
			if($query){
				echo "Product Modified";
				
			}
			else{
				echo mysqli_error($conn);
			}
		}
		else if(isset($_POST['pupdate']) && $_FILES['pimage']['name']==""){
			$pid=$_POST['pid'];
			$pname=$_POST['pname'];
			$pquantity=$_POST['pquantity'];
			$sql="UPDATE products SET pname='$pname',pquantity='$pquantity' where id='$pid'";
			$query=mysqli_query($conn,$sql);
			if($query){
				echo "Product Modified";
				exit();
			}
			else{
				echo mysqli_error($conn);
			}
		}


	?>
<!-- Product Delete Code-->
<?php
	if(isset($_POST['pdelete'])){
		$pid=$_POST['pid'];
		mysqli_query($conn,"delete from products where id ='$pid'");
	}
?>
	
	</body>
</html>