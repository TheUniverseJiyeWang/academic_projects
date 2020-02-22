<html>
<head>
<title>
signup.php
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
?>

<b>User Information</b>
<p>
<form action="submit.php" method="POST">


Username:<input type="text" name="uname">
<p>
Email Address:<input type="text" name="uemail">
<p>	
Phone Number:<input type="int" name="uphonenumber">
<p>
Password:<input type="pass" name="upassword">
<p>

<input type="submit" value="Submit">
</form>



<p>
<a href="main.php"> back to MAIN menu</a>


</body>
</html>