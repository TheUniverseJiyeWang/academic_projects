
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

<script type="text/javascript">
	function showPrice(sel){
		
		document.getElementById("price").value = sel.value;
	}
	var sum=0;
	function addItemToTable(){
		if(document.getElementById("custId").value=='--Select--' || document.getElementById("custId").value==''){
			alert('Kindly select a Customer Id');
			return false;
		}
		if(document.getElementById("itemId").value=='--Select--' || document.getElementById("itemId").value==''){
			alert('Kindly select an Item Id');
			return false;
		}
		if(document.getElementById("price").value=='--Select--' || document.getElementById("price").value==''){
			alert('Kindly mention a price for the item');
			return false;
		}
		if(document.getElementById("qty").value=='--Select--' || document.getElementById("qty").value==''){
			alert('Kindly enter the Quantity');
			return false;
		}
		
		var table=document.getElementById("itemTable");
	
			var row=table.insertRow(table.getElementsByTagName("tr").length);
			var totalPrice=0;

			for(var j=0;j<4;j++){
				var cell=row.insertCell(j);
				if(j==0)
					cell.innerHTML="<input type='hidden' name='td"+(table.getElementsByTagName("tr").length-1)+"_"+j+"' value="+document.getElementById("itemId").options[document.getElementById("itemId").selectedIndex].text+">"+document.getElementById("itemId").options[document.getElementById("itemId").selectedIndex].text;
				else if(j==1)
					cell.innerHTML="<input type='hidden' name='td"+(table.getElementsByTagName("tr").length-1)+"_"+j+"' value="+document.getElementById("itemId").value+">"+document.getElementById("itemId").value;
				else if(j==2)
					cell.innerHTML="<input type='hidden' name='td"+(table.getElementsByTagName("tr").length-1)+"_"+j+"' value="+document.getElementById("qty").value+">"+document.getElementById("qty").value;
				else if(j==3){
					var itemPrice = parseFloat(document.getElementById("itemId").value) * parseFloat(document.getElementById("qty").value);
					sum += parseFloat(itemPrice);
					cell.innerHTML="<input type='hidden' name='td"+(table.getElementsByTagName("tr").length-1)+"_"+j+"' value="+itemPrice+">"+itemPrice;
				}
			}
			document.getElementById("tableLength").value = table.getElementsByTagName("tr").length;
			//alert('cid'+document.getElementById("custId").value);
			var result = '';
			$.ajax({
				   url : "getTotalPrice.php",
				   type : "POST", 
				   data : { cid : document.getElementById("custId").value },
				 
					success : function (response) {
				 
					//alert($.trim(response));
					result = $.trim(response);
					var discountCode=0;	
					if(parseInt(result)>500)
						discountCode=5;	
					else if(parseInt(result)>400 && parseInt(result)<=500)
						discountCode=4;	
					else if(parseInt(result)>300 && parseInt(result)<=400)
						discountCode=3;	
					else if(parseInt(result)>200 && parseInt(result)<=300)
						discountCode=2;	
					else if(parseInt(result)>100 && parseInt(result)<=200)
						discountCode=1;	
					else if(parseInt(result)<100)
						discountCode=0;	
					//alert('discountCode'+discountCode);
					totalPrice = parseFloat(sum) * parseFloat(1-2.5*discountCode/100);
					document.getElementById("totalPrice").value = totalPrice;
					
					}
			});
			
	}

</script>

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


//function for inserting user record into mysql db
function insertRecord() {

//getting the values of textfields
$cid = $_POST["custId"];
$itemId = $_POST["itemId"];
$qty = $_POST["qty"];
$totalPrice = $_POST["totalPrice"];
$tableLength = $_POST["tableLength"];
//loading dbguest.php file
require("dbguest.php");

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) die("Couldn't connect to MySQL");
	$message="Successfully connected to server";

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));
$count=0;
$query = "insert into transaction (CID,TransactionDate,TotalPrice) values ('".$cid."',CURDATE(),'".$totalPrice."')";
	$result = mysqli_query($link, $query);
	
	$ok = mysqli_query($link, $query);
		if (!$ok) {
			$message="Error in adding transaction: " . mysqli_error($link);
			
		}
		else{
			$message="Transaction was added successfully.";
		}
			//		echo "<script type='text/javascript'>alert(\"".$message."\");</script>";
		
	$transactionNo=0;
	$query = "select TransactionNo from transaction where CID='".$cid."'  and TotalPrice='".$totalPrice."'";
	$result = mysqli_query($link, $query);
	
	while ($a_row = mysqli_fetch_row($result)) {
	
		foreach ($a_row as $field) $transactionNo=$field;
		
	}
	$tdId = "";
	for ($num = 1; $num < $tableLength; $num += 1) { 
		$tdId = "td".(string)$num."_0";
		$qtyId = "td".(string)$num."_2";
		
		$itemId = $_POST[$tdId];
		$quantity = $_POST[$qtyId];
		$query = "insert into itemspurchased (TransactionNo,ItemId,Quantity) values ('".$transactionNo."','".$itemId."','".$quantity."')";
		$ok = mysqli_query($link, $query);
		if (!$ok) {
			$message="Error in adding itemsPurchased: " . mysqli_error($link);
			break;
		}
		else{
			$message="Transaction was added successfully.";
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
<div class="jumbotron" style=" background-image: url(images/image2.jpg); border-radius:0px;background-size: 100% auto; background-attachment: fixed;  position: relative; min-height: 800px; box-shadow: 0 3000px rgba(0,0,0, 0.7) inset;
								  height: calc(30vh);">
<center>



<form  method="post">
<h1 style="color: #faebd7">Add a New Transaction</h1> 
<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Select a Customer Id </label>
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

$query = "SELECT CID FROM customer";
					$result = mysqli_query($link, $query);
					
					print("<select name='custId' class='form-control' id='custId' placeholder='Select a Customer Id'>");
					print("<option value='--Select--'>--Select--</option>");
						
					
					while ($a_row = mysqli_fetch_row($result)) {
						print("<option value='$a_row[0]'>$a_row[0]</option>");
						
						
					}
					print "</select>";
					
mysqli_close($link);
?>
				</div></div>
			</div>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Select an Item Id </label>
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

$query = "SELECT _id, price FROM item";
					$result = mysqli_query($link, $query);
					
					print("<select name='itemId' class='form-control' id='itemId' placeholder='Select an Item Id' onchange='showPrice(this);'>");
					print("<option value='--Select--'>--Select--</option>");
						
					
					while ($a_row = mysqli_fetch_row($result)) {
						print("<option value='$a_row[1]'>$a_row[0]</option>");
						
						
					}
					print "</select>";
					
mysqli_close($link);
?>
				</div></div>
			</div>
			<br/>
			<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Item Price</label>
<div class="col-sm-8">
<div class="col-sm-10">
<input class='form-control' autocomplete="false" type="text" name="price" readonly="true" id="price" placeholder="Item Price" required>
				</div></div>
			</div>
			<br/>
			
			<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Enter the Item Quantity</label>
<div class="col-sm-8">
<div class="col-sm-10">
					<input class='form-control' autocomplete="false" type="number" name="qty" id="qty" placeholder="Item Quantity" required>
				
				<button type="button" class="btn btn-primary" name="addItem" onclick="addItemToTable()">
					Add Item
				</button>
				</div>
				</div>
			</div>
			
			<br/>
			<br/>
			<div class='table-users' ><div class='header'>
			<input type="hidden" id="tableLength" name="tableLength"/></div>
				<table id="itemTable" border="1">
					<tr>
						<th>Item ID</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total Item Price</th>
					</tr>
				
				</table>
				</div>
				<br/>
				<div class="form-group row" style="display:inline-block;" >
<label for="table" class="col-sm-4 col-form-label" style="color: #faebd7">Total Price</label>
<div class="col-sm-8">
<div class="col-sm-10">
					<input class='form-control' autocomplete="false" type="text" name="totalPrice" readonly="true" id="totalPrice" placeholder="Total Price" required>
			</div>
			</div>
			</div>

			<br/>
			<div class="container-login100-form-btn">
				<button class="btn btn-primary" type="submit" name="submit">
					Add Transaction
				</button>
			</div>
							</div>
			
</form>

</center>
</body>
</html>
