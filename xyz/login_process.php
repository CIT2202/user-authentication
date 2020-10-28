<?php
session_start();
?>
<!DOCTYPE html>
<html lang = "en">
<head>
<title>Login Process</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
</head>

<body>

  <?php
  if(isset($_POST['login']))
  {
  	$email=$_POST['email'];
  	$password=$_POST['password'];
  	if($email==="testuser@hud.ac.uk" && $password === "letmein")
  	{
  		$_SESSION["user"]=$email;
  		header( "Location: index.php" );
  	}
  }else{
  	header( "Location: login.php" );
  }
  ?>

</body>
</html>
