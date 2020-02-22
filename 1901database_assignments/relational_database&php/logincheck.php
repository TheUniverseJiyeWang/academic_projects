<html>
<head>
<title>
submit
</title>
</head>
<body>

<?php

        $host = "localhost";
        $user = "ji_wang";  // your user name
	    $pass = "A00426401";  // your password
	    $db = "ji_wang";  // the name of your database

	$link = mysqli_connect($host, $user, $pass, $db);

	if (!$link) die("Couldn't connect to MySQL");
	print "Successfully connected to server<p>";

	mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));

		$uemail = $_POST["lemail"];
		$upassword = $_POST["lpassword"];

	$sql_select = "SELECT uemail, upassword FROM User WHERE uemail = '$uemail' AND upassword = '$upassword'";

	$ret = mysqli_query($link,$sql_select);

	$row = mysqli_fetch_array($ret);

	if ($uemail == $row['uemail'] && $upassword == $row['upassword']) {
		echo "Successfully Login";
	}else{
		echo "Login Error";
	}

	mysqli_close($link);

?>

<p>
<a href="main.php"> back to MAIN menu</a>

</body>
</html>