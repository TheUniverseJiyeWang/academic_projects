
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

<script text="type/javascript">
	//function to add author information into html table
	function addAuthorToTable(){

		var table=document.getElementById("authorTable");
		
		var row=table.insertRow(table.getElementsByTagName("tr").length);
		for(var j=0;j<2;j++){
			var cell=row.insertCell(j);
			if(j==0)
				cell.innerHTML="<input type='hidden' name='td"+(table.getElementsByTagName("tr").length-1)+"_"+j+"' value="+document.getElementById("authorId").value+">"+document.getElementById("authorId").value;
			else if(j==1)
				cell.innerHTML="<input type='hidden' name='td"+(table.getElementsByTagName("tr").length-1)+"_"+j+"' value="+document.getElementById("authorId").options[document.getElementById("authorId").selectedIndex].text+">"+document.getElementById("authorId").options[document.getElementById("authorId").selectedIndex].text;

		}
		document.getElementById("tableLength").value=table.getElementsByTagName("tr").length;
				
	}

</script>
<style>
tbody{
	height:auto;
	max-height:200px;
	min-height:50px;

}
.table-users{
	width: fit-content;
}
.jumbotron{
	margin-bottom:-100px;
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

	insertRecord();
} 


//function for inserting  record into mysql db
function insertRecord() {

	//getting the values of textfields
	$title = $_POST["title"];
	$magazineId = $_POST["magazineId"];
	$volNo = $_POST["volNo"];
	$pageNo = $_POST["pageNo"];
	$year = $_POST["year"];
	$tableLength = $_POST["tableLength"];

	//loading dbguest.php file
	require("dbguest.php");

	$link = mysqli_connect($host, $user, $pass, $db);
	if (!$link) die("Couldn't connect to MySQL");
	$message="Successfully connected to server";

	mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));

	$id=0;
	$query = "insert into article (volNo,Title,pageNo,Year_publication,Magazine_ID) values ('".$volNo."','".$title."','".$pageNo."','".$year."','".$magazineId."')";
	$ok = mysqli_query($link, $query);
	if (!$ok) {
		$message="Error in adding article: " . mysqli_error($link);

	}
	else{
		$message="Article was added successfullhy.";
	}
	
		
	$query = "select id from article where volNo='".$volNo."' and Title='".$title."' and pageNo='".$pageNo."' and Year_publication='".$year."' and Magazine_ID='".$magazineId."'";
	$result = mysqli_query($link, $query);
	
		
	while ($a_row = mysqli_fetch_row($result)) {

		foreach ($a_row as $field) $id=$field;
			
	}
	
		
	$tdId = "";
	for ($num = 1; $num < $tableLength; $num += 1) { 
		$tdId = "td".(string)$num."_0";
		$authorId = $_POST[$tdId];
		$query = "insert into article_authors (Article_ID,Author_ID) values ('".$id."','".$authorId."')";
		$ok = mysqli_query($link, $query);
		if (!$ok) {
			$message="Error in adding article: " . mysqli_error($link);
			break;
		}
		else{
			$message="Article was added successfullhy.";
		}
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
<div class="jumbotron" style=" background-image: url(images/image2.jpg); border-radius:0px;background-size: 100% auto; background-attachment: fixed;  position: relative; min-height: 1200px; box-shadow: 0 3000px rgba(0,0,0, 0.7) inset;
	height: auto;">
<center>
	<form  method="post">
		<h1 style="color: #faebd7">Add an Article</h1>
		<div class="form-group row" style="display:inline-block;" >
			<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter the Title</label>
			<div class="col-sm-8">
				<div class="col-sm-10">
					<input class='form-control' autocomplete="false" type="text" name="title" placeholder="Title" required>
				</div>
			</div>
		</div><br/>
		<br/>
		<div class="form-group row" style="display:inline-block;" >
			<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Select a Magazine </label>
			<div class="col-sm-8">
				<div class="col-sm-10">			
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

					$query = "SELECT _id, name FROM magazine";
					$result = mysqli_query($link, $query);
					
					
					print("<select class='form-control' name='magazineId' placeholder='Select a Magazine'>");


					while ($a_row = mysqli_fetch_row($result)) {
						print("<option value=".$a_row[0].">".$a_row[1]."</option>");
							
							
					}
					print "</select></div>";
						
					mysqli_close($link);
				?>

				</div>
			</div>
			<br/>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
				<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter Volume Number</label>
					<div class="col-sm-8">
						<div class="col-sm-10">	
							<input class='form-control'autocomplete="false" type="text" name="volNo" placeholder="Volume Number" required>
						</div>
					</div>
			</div>
			<br/>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
				<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter Page Number  </label>
					<div class="col-sm-8">
						<div class="col-sm-10">	
							<input class='form-control' autocomplete="false" type="number" name="pageNo" placeholder="Page Number" required>
						</div>
					</div>	
			</div>
			<br/>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
				<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter Year of Publication  </label>
					<div class="col-sm-8">
						<div class="col-sm-10">	
							<input class='form-control' autocomplete="false" type="number" name="year" placeholder="Year of Publication" required>
						</div>	
					</div>	
			</div>
			<br/>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
				<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Select an Author </label>
					<div class="col-sm-8">
						<div class="col-sm-6">

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

							$query = "SELECT _id, fname, lname FROM author";
							$result = mysqli_query($link, $query);
							print("<select class='form-control' name='authorId' id='authorId' placeholder='Select an Author'>");


							while ($a_row = mysqli_fetch_row($result)) {
								print("<option value='$a_row[0]'>$a_row[1] $a_row[2]</option>");


							}
							print "</select>";

							mysqli_close($link);
						?>



					</div>
					<button type="button"  class="btn btn-primary"  name="addAuthor" onclick="addAuthorToTable()">
							Add Author
					</button>
				</div>
			</div>
			<br/>
			<br/>
			<div class='table-users' ><div class='header'>
				<input type="hidden" id="tableLength" name="tableLength"/></div>
					<table id="authorTable" cellspacing='0'>
						<tr>
							<th>Author ID</th>
							<th>Author Name</th>
						</tr>

					</table>
					
				</div>
				

				<button  class="btn btn-primary"  type="submit" name="submit">
					Add
				</button>

			</form>
		</center>

</body>
</html>
