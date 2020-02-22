
	
<?php
//php code starts here

//enabling debugging in php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$message ="";


	//getting the values of textfields
	$action = $_POST["action"];
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
	
	if($action=="insert"){
	
		$query = "insert into customer (FirstName,LastName,TelephoneNo,MailingAddress,DiscountCode) values ('".$fName."','".$lName."','".$telNo."','".$mAddress."','0')";
		$ok = mysqli_query($link, $query);
		if (!$ok) {
			$message="Error in adding customer: " . mysqli_error($link);
						
		}
		else{
			$message="Customer was added successfully.";
		}
	}
	else if($action=="update"){
		$CID='';
		$query = "select CID from customer where FirstName='".$fName."' and LastName='".$lName."'";
		$result = mysqli_query($link, $query);
		
		while ($a_row = mysqli_fetch_row($result)) {
		
			foreach ($a_row as $field) $CID=$field;
			
		}
		
		$query = "update customer set FirstName='".$fName."',LastName='".$lName."',TelephoneNo='".$telNo."',MailingAddress='".$mAddress."' where CID='".$CID."'";
		$ok = mysqli_query($link, $query);
		if (!$ok) {
			$message="Error in updating customer: " . mysqli_error($link);
						
		}
		else{
			$message="Customer was updated successfully.";
		}
	}
		
	echo $message;
		

//php code ends here
?>
	