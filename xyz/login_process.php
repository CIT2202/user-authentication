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
  	if($email === "u01234567@hud.ac.uk" && $password === "letmein")
  	{
  		$_SESSION["user"] = $email;
  		echo "<p>Correct details, you can now go to <a href='index.php'>homepage</a></p>";
  	}else{
  	  echo "<p>That's the wrong username/password</p>";
    }
  }else{
     echo "<p>You shouldn't have got to this page.</p>";
  }
  ?>

</body>
</html>
