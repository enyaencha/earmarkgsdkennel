<?php session_start();
include('includes/dbconn.php');
if (isset($_POST['delete'])) {
	$id = $_POST['id'];
	$sql = "UPDATE tblcnp SET voided = 1 WHERE id = '$id'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	header("location:update_cnp.php");
	
	}?>

