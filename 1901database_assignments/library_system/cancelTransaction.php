
<!DOCTYPE html>
<html lang="en">
<head>
<title>Halifax Science library</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/tableStyle.css"/>

<style>
.jumbotron{
margin-bottom:0px;
margin-top:-20px;
 
}
.jumbotron .h1{
	color: #faebd7;
  }

</style>

<?php
//php code starts here

//enabling debugging in php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$message ="";

//Checking for the event when submit button is pressed
if(isset($_POST['submit'])){

	cancelTransaction();
} 


//function for cancelling transaction
function cancelTransaction() {

//getting the values of textfields
$txnNo = $_POST["txnNo"];
;
//loading dbguest.php file
require("dbguest.php");

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) die("Couldn't connect to MySQL");
	$message="Successfully connected to server";

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));
$count=0;

	$query = "select count(*) as count from transaction where TransactionNo='".$txnNo."'";
	$result = mysqli_query($link, $query);
	
	while ($a_row = mysqli_fetch_row($result)) {
	
		foreach ($a_row as $field) $count=$field;
		
	}
	if($count>0){
		
		$count1=0;

		$query = "select count(*) as count from transaction where TransactionNo='".$txnNo."'and TransactionDate > DATE_SUB(CURDATE(),INTERVAL 30 DAY);";
		$result = mysqli_query($link, $query);
		
		while ($a_row = mysqli_fetch_row($result)) {
		
			foreach ($a_row as $field) $count1=$field;
			
		}
		if($count1>0){
			
			$query = "delete from  itemspurchased where TransactionNo='".$txnNo."'";
				$result = mysqli_query($link, $query);
				
				$ok = mysqli_query($link, $query);
					if (!$ok) {
						$message="Error in cancelling the transaction: " . mysqli_error($link);
						
					}
					else{
						$message="Transaction was cancelled successfully.";
					}
		
			$query = "delete from  transaction where TransactionNo='".$txnNo."'";
				$result = mysqli_query($link, $query);
				
				$ok = mysqli_query($link, $query);
					if (!$ok) {
						$message="Error in cancelling the transaction: " . mysqli_error($link);
						
					}
					else{
						$message="Transaction was cancelled successfully.";
					}
		}
		else{
			$message="There is no Transaction related to this number that has occurred in the last 30 days.";
		}
					
	}
	else{
		$message="Transaction Number does not exists. Kindly try with a different value.";
	}
	
	
		
		echo "<script type='text/javascript'>alert(\"".$message."\");</script>";
		

		
	mysqli_close($link);

}
//php code ends here
?>

</head>
<body>

<nav class="navbar navbar-inverse">
<div class="container-fluid">
<div class="navbar-header active">
  <a class="navbar-brand" style="color: #ffffff" href="index.php">Halifax Science Library</a>
</div>
<ul class="nav navbar-nav">
  <li ><a href="showTable.php">Show Table</a></li>
  <li> <a href="addNewArticle.php">Add New Article</a></li>
  <li><a href="addNewCustomer.php">Add New Customer</a></li>
  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Transaction<span class="caret"></span></a>
	<ul class="dropdown-menu">
	  <li><a href="addNewTransaction.php">Add New Transaction</a></li>
	  <li><a href="cancelTransaction.php">Cancel Transaction</a></li>

	</ul>
  </li>
 
</ul>
</div>
</nav>
<div class="jumbotron" style=" background-image: url(images/image2.jpg); border-radius:0px;background-size: 100% auto; background-attachment: fixed;  position: relative; min-height: 800px; box-shadow: 0 3000px rgba(0,0,0, 0.7) inset;
								  height: calc(30vh);">
<center>

<br/>
<br/>
<br/>

<form  method="post">
<h1 style="color: #faebd7">Cancel Transaction</h1>
<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter a Transaction Number</label>
<div class="col-sm-8">
<div class="col-sm-10">
				<input  class='form-control' autocomplete="false" type="text" name="txnNo" id="txnNo" placeholder="Transaction Number" required>
				
			</div>			
			</div>
			</div>
			<br/>
			
			<div class="container-login100-form-btn">
				<button class="btn btn-primary"  type="submit" name="submit">
					Cancel Transaction
				</button>
			</div>
</form>

</center>
</body>
</html>
