<html>
<head>
<title>
submit
</title>
</head>
<body>

<?php


        $host = "localhost";
        $user = "ji_wang";  
	    $pass = "A00426401"; 
	    $db = "ji_wang"; 

	$link = mysqli_connect($host, $user, $pass, $db);

	if (!$link) die("Couldn't connect to MySQL");
	print "Successfully connected to server<p>";

	mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));

		$uname = $_POST["uname"];
		$uemail = $_POST["uemail"];
		$uphonenumber = $_POST["uphonenumber"];
		$upassword = $_POST["upassword"];

	$sql = "INSERT INTO Users (uname, uemail, uphonenumber, upassword) VALUES ('$uname', '$uemail', '$uphonenumber', '$upassword')";

	if (mysqli_query($link, $sql)) {
		echo "Successfully Signup";
	}else{
		echo "Signup Error";
	}

	mysqli_close($link);
	
?>

<p>
<a href="main.php"> back to MAIN menu</a>

</body>
</html>