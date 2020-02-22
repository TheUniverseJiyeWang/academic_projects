
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
tbody{
	
  height:auto;
 max-height:200px;
 min-height:50px;
 
}
.table-users{
  width: fit-content;
}
</style>
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


<form  method="post" >
<h1 style="color: #faebd7">Show Table's Data</h1>
<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Select a Table</label>
<div class="col-sm-8">
<?php
//php code starts here

//enabling debugging in php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$message ="";

//loading dbguest.php file
require("dbguest.php");

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) die("Couldn't connect to MySQL");
	$message="Successfully connected to server";

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));

$query = "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema='$db';";
					$result = mysqli_query($link, $query);
					print("<div class=\"col-sm-10\"><select class='form-control' name='tableName' placeholder='Select a Table'>");

					
					while ($a_row = mysqli_fetch_row($result)) {
						foreach ($a_row as $field) print("<option value='$field'>$field</option>");
						
						
					}
					print "</select></div>";
					
mysqli_close($link);
?>

</div>
<br/>
<br/>
<br/>
<br/>
<input type="submit" class="btn btn-primary" name="submit" value="Show Data">
</form>
<br/>
<br/>
<br/>
<br/>
	
<?php
//Checking for the event when submit button is pressed
if(isset($_POST['submit'])){

	insertRecord();
} 


//function for inserting user record into mysql db
function insertRecord() {

//getting the values of textfields
$table = $_POST["tableName"];

//loading dbguest.php file
require("dbguest.php");

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) die("Couldn't connect to MySQL");
	$message="Successfully connected to server";

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));


$query = "SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema='$db' AND table_name='$table'";
					$result = mysqli_query($link, $query);
					
					print("<div class='table-users' ><div class='header'>$table details</div>");

					//Displaying details using html table
					print "<table cellspacing='0'>\n";
					print("<tr>");
						$count=1;
					while ($a_row = mysqli_fetch_row($result)) {
					
						
						foreach ($a_row as $field) print "<th>$field</th>";
						
						
					}
					print("</tr>");
					
					$query = "SELECT * FROM $table ";
					$result = mysqli_query($link, $query);
					
					
					while ($a_row = mysqli_fetch_row($result)) {
						print("<tr>");
						foreach ($a_row as $field) print "<td>$field</td>";
						
						print("</tr>");
					}
					print "</table>";
					
mysqli_close($link);

}
//php code ends here
?>

</center>
</div>
</body>
</html>
