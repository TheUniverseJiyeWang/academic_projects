
	
<?php
//php code starts here

//enabling debugging in php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$message ="";


	//getting the values of textfields
	$cid = $_POST["cid"];
   
	//loading dbguest.php file
   	require("dbguest.php");

	$link = mysqli_connect($host, $user, $pass, $db);
	if (!$link) die("Couldn't connect to MySQL");
		$message="Successfully connected to server";

	mysqli_select_db($link, $db)
		or die("Couldn't open $db: ".mysqli_error($link));
	

		$totalPrice='';
		$query = "SELECT SUM(TotalPrice) as TotalPrice FROM transaction WHERE CID='".$cid."' and TransactionDate > DATE_SUB(CURDATE(),INTERVAL 5 YEAR)";
		$result = mysqli_query($link, $query);
		
		while ($a_row = mysqli_fetch_row($result)) {
		
			foreach ($a_row as $field) $totalPrice=$field;
			
		}
		$message = $totalPrice;
		
		
	echo $message;
		

//php code ends here
?>
	