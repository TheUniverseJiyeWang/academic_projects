
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

	insertCustomer();
} 


//function for inserting customer record into mysql db
function insertCustomer() {

//getting the values of textfields
$fName = $_POST["fName"];
$lName = $_POST["lName"];
$telNo = $_POST["telNo"];
$mAddress = $_POST["mAddress"];


//loading dbguest.php file
require("dbguest.php");

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) die("Couldn't connect to MySQL");
	$message="Successfully connected to server";

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));
$count=0;
$query = "select count(*) as count from customer where FirstName='".$fName."' and LastName='".$lName."'";
	$result = mysqli_query($link, $query);
	
	while ($a_row = mysqli_fetch_row($result)) {
	
		foreach ($a_row as $field) $count=$field;
		
	}
	
					
mysqli_close($link);
	if ($count>0) {
			$message="A customer with same first and last name already exists. Is this a new customer or not? Press Ok for Yes else press Cancel.";
			echo "<script type='text/javascript'>var res=confirm(\"".$message."\");
			var action='';
			if(res){
				action='insert';
			}
			else{
				action='update';
			}
			$.ajax({
				   url : \"insertUpdateCustomer.php\", // the resource where youre request will go throw
				   type : \"POST\", // HTTP verb
				   data : { action: action, fName : '".$fName."',lName : '".$lName."', telNo:'".$telNo."', mAddress: '".$mAddress."' },
				 
					success : function (response) {
				 
					alert($.trim(response));
					}
			});
				
			</script>";
			
			
		}
	else{
		//loading dbguest.php file
require("dbguest.php");

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) die("Couldn't connect to MySQL");
	$message="Successfully connected to server";

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));

			$query = "insert into customer (FirstName,LastName,TelephoneNo,MailingAddress,DiscountCode) values ('".$fName."','".$lName."','".$telNo."','".$mAddress."','0')";
			$ok = mysqli_query($link, $query);
			if (!$ok) {
					$message="Error in adding customer: " . mysqli_error($link);
					
				}
			else{
					$message="Customer was added successfully.";
				}
					echo "<script type='text/javascript'>alert(\"".$message."\");</script>";
	mysqli_close($link);
	}
	
	//	echo "<script type='text/javascript'>alert(\"".$message."\");</script>";

	
						


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
<h1 style="color: #faebd7">Add a New Customer</h1>
<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter First Name </label>
<div class="col-sm-8">
<div class="col-sm-10">
			<input  class='form-control' autocomplete="false" type="text" name="fName" placeholder="First Name" required>
			</div>
</div>				
			</div>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter Last Name</label>
<div class="col-sm-8">
<div class="col-sm-10">
				<input  class='form-control' autocomplete="false" type="text" name="lName" placeholder="Last Name" required>
				
			</div>
			</div>
			</div>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter Telephone Number</label>
<div class="col-sm-8">
<div class="col-sm-10">
				<input  class='form-control' autocomplete="false" type="number" name="telNo" placeholder="Telephone Number" required>
			
			</div>
			</div>
			</div>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter Mailing Address</label>
<div class="col-sm-8">
<div class="col-sm-10">
			<input  class='form-control' autocomplete="false" type="textarea" name="mAddress" placeholder="Mailing Address" required>
			</div>
			</div>
			</div>
			<br/>
			<br/>
			
			
			<div >
				<button class="btn btn-primary"  type="submit" name="submit">
					Add Customer
				</button>
			</div>
</form>
</center>


</body>
</html>
