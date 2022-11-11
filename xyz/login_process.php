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
  try{
    //you will need to change these settings so they match your database
       $conn = new PDO('mysql:host=localhost;dbname=cit2202', 'cit2202', 'letmein');
}
catch (PDOException $exception)
{
    echo "Oh no, there was a problem" . $exception->getMessage();
}

// check make sure they have come via the login form
if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    //test to see if we have got a row back i.e. the correct email
    if($row = $stmt->fetch()){
       //now check the password is correct
       if(password_verify($password, $row["password"])) {
          //we have the correct username and password so assign the email address to a session variable
          $_SESSION["user"] = $email;
          echo "<p>Correct details, you can now go to <a href='index.php'>homepage</a></p>";
      }else{
          // wrong password
          echo "<p>That's the wrong username/password</p>";
      }
   }else{
      //wrong username
      echo "<p>That's the wrong username/password</p>";
   }
}else{
    //they shouldn't have to got to this page, redirect them to the login
    header( "Location: login.php" );
}
  ?>

</body>
</html>
