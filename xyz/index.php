<?php
session_start();
if(!isset($_SESSION["user"]))
{
	//user tried to access the page without logging in
        //redirect them to the login page
	header( "Location: login.php" );
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Homepage of XYZ inc.</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" >
</head>

<body>
<?php echo "<p>You are logged in as : {$_SESSION['user']}</p>"; ?>
<h1>Welcome to XYZ inc.</h1>
<p>Find out everything you need to know about the XYZ company</p>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="page1.php">Page 1</a></li>
        <li><a href="page2.php">Page 2</a></li>
        <li><a href="page3.php">Page 3</a></li>
    </ul>
</nav>


</body>
</html>
