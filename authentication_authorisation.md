# User Authentication and Authorisation
Authentication is checking who someone is. We use authentication when users sign into a website, we check their username and password to make sure they are who the say they are.

Authorisation is checking if the user has permission to access part of a site or perform a particular action. For example, checking if a user on Brightspace has a role of 'tutor'. If they do, they are allowed to edit the teaching materials.

Authentication and authorisation are the basis for login systems in web applications.

## Authentication a simple Example
Here's a simple example:-

login.html
```html
<form action="login_process.php" method="post">
    <label for="username">Email address:</label>
    <input type="email" id="email" name="email">
    <label for="password" >Password:</label>
    <input type="password" id="password" name="password">
    <input type="submit" name="login" value="Login">
</form>
```

login_process.php
```php
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
  	$email = $_POST['email'];
  	$password = $_POST['password'];
  	if($email === "testuser@hud.ac.uk" && $password === "letmein")
  	{
  		$_SESSION["email"] = $email;
  		header( "Location: index.php" );
  	}
  }else{
  	header( "Location: login.php" );
  }
  ?>
</body>
</html>
```
The user enters an email and password into the form. When this form is submitted, PHP is used to check the  email and password (authentication) we store their email address in a session variable. The line of code:

```php
header( "Location: index.php" );
```

Is used to redirect the user to a different page. So if they enter the correct details, the user will be automatically taken to a page called *index.php*.

### Protecting pages
If there are pages in the site that we want to restrict access to we can check to see if the *email* session variable has been set.

index.php
```php
<?php
session_start();
if(!isset($_SESSION["email"]))
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
<meta http-equiv="content-type" content="text/html;charset=utf-8">
</head>
<body>
<?php echo "<p>You are logged in as : {$_SESSION['email']}</p>"; ?>
<h1>Welcome to XYZ inc.</h1>
<p>Find out everything you need to know about the XYZ company</p>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="page1.php">Page 1</a></li>
        <li><a href="page2.php">Page 2</a></li>
        <li><a href="page3.php">Page 3</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
</body>
</html>
```
Take a few minutes to look through the code.

## Authentication using a database
The previous example is clearly very simple. Most useful websites use a database to store usernames and passwords e.g.

users

| id | email             | password |
|----|-------------------|----------|
| 1  | ghulam@xyz.co.uk  | huddersfield  |
| 2  | regina@xyz.co.uk  | 123456 |
| 3  | olive@xyz.co.uk   | qwerty |

We can then check the email address and password that the user enters against the database e.g.

```php
<?php
$email=$_POST['email'];
$password=$_POST['password'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password=:password");
$stmt->bindValue(':email',$email);
$stmt->bindValue(':password',$password);
$stmt->execute();

if($row = $stmt->fetch())
{
	$_SESSION["email"] = $email;
	header( "Location: index.php" );
}
?>
```

If we successfully find a row in the database table with the email and password that the user has entered we create the session variable.

## Hashing Passwords
We shouldn't store plain text passwords in database tables.
If security is breached, hackers will have access to user passwords. Instead passwords should be 'hashed' to disguise the actual password. Hashing involves converting the password to a fixed length 'hash' (it looks like a random collection of characters). Here are some examples that use the MD5 hashing function.

```php
<?php
echo md5("password"); //outputs 5f4dcc3b5aa765d61d8327deb882cf99
echo "<br>";
echo md5("Matthew"); //outputs 64730ca35ed9274ff6aa8a719407fe53
echo "<br>";
echo md5("letmein"); //outputs 0d107d09f5bbe40cade3de5c71e9e9b7
?>
```
Here are some key points about hashing functions
* Hashing functions are 'one way' functions. It is practically infeasible to reverse the hash.
* Hashing functions are deterministic. Every time we hash the same password we get the same result.

So if hashes can't be reversed how can we check the user's password against the database?

Here's how it works:
* The user registers and chooses their password. The password is hashed and stored in the database table.
* When the user logs in they enter a password.
* This entered password is also hashed and then compared to the stored password.
* If they match, the user login is successful.

### Hashes can be cracked
Although it isn't practical to reverse a hash, every time we hash a password we end up with the same string of characters. Two users with the same password will have the same hash.

Hackers can use look-up tables which store commonly used passwords and their hashes.

| id | password   | hash                             |
|----|------------|----------------------------------|
| 1  | password   | 5f4dcc3b5aa765d61d8327deb882cf99 |
| 2  | Matthew    | 64730ca35ed9274ff6aa8a719407fe53 |
| 3  | letmein    | 0d107d09f5bbe40cade3de5c71e9e9b7 |
|... |...         |...                               |

A hacker can then search the attacked database for hashes that match those in the look-up table and find the original password.

In reality, the look-up tables are often more complex than this. Have a look at https://en.wikipedia.org/wiki/Rainbow_table if you are interested.

### Using a salt
To make hashed password more secure we can add a random string into the password. This is known as a salt. For example:

* Password = huddersfield
* Salt (randomly generated by PHP) = bpgZSK5sUyl7Nvf0NapIP
* Input to the hashing function = *bpgZSK5sUyl7Nvf0NapIP*huddersfield
* Hashed password = OaDS3x95ulTTUMEy1AEQKDxg2CYNw0..
* Value stored in the database = *bpgZSK5sUyl7Nvf0NapIP*OaDS3x95ulTTUMEy1AEQKDxg2CYNw0..

By making the original password more complex it offers protection against look-up tables. Note that we put the salt on the start of the hash when we store it in the database. PHP needs to know the value of the salt so it can be combined with the user entered password and compared to the hash.

There are different hashing functions. The MD5 example shown above is widely known, but has vulnerabilities. It shouldn't be used for storing passwords.

### ```password_hash()```

PHP has a function ```password_hash()``` that will hash values for us and automatically generate a salt. By default ```password_hash()``` uses an algorithm called **bcrypt**, although we can manually specify alternatives if we want to.

### Checking user input against a hashed password
When users register with a site we can use ```password_hash()``` to hash their password and then store this in a database.

When this user tries to login we can use the ```password_verify()``` function to test the entered password. Here's a simple example:

```php
<?php
password_verify('huddersfield','$2y$10$em6X15KQt4prqPeJ0g9Dg.2zLzhC/WKPrKpRfdHDw0VNUkH/FR9lK'); //returns true the password and hash are a match
?>
```
```password_verify()``` accepts two arguments, a string for the password and a string for the hash. If the password matches the hash ```password_verify()``` return true.

Here's how we could use this function in a login system:

```php
...
$email = $_POST['email'];
$password = $_POST['password'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindValue(':email', $email);
$stmt->execute();
if($row = $stmt->fetch()){
   if (password_verify($password, $row["password"])) {
      $_SESSION["email"] = $email;
      echo "<p>Correct details, you can now go to <a href='index.php'>homepage</a></p>";
   }else{
      echo "<p>That's the wrong username/password</p>";
   }
}else{
   echo "<p>That's the wrong username/password</p>";
}
...
```

Note that we don't use SQL to test the password. We simply retrieve the row that matches the email address. We then access the password field from this row (```$row["password"]```) and use ```password_verify()``` to test this against the user entered password.

## Authorisation
Typically in a web application different users will have different roles e.g.
* E-commerce website
  * Customers can browse, search, leave reviews, make orders etc.
  * An administrator can add, edit and delete products.
* Brightspace
  * Students can view learning materials and submit assignments.
  * Tutors can post learning materials, view assignments.
  * Admin can create and delete modules.

We can store information about the user's role in our database.

users

| id | email             | password                                                     |role|
|----|-------------------|--------------------------------------------------------------|----|
| 1  | ghulam@xyz.co.uk  | $2y$10$7oKRMLWSD8wPjmMhdOz/9.gZ5j47leH.vsYxZZKiuY5rjxamfcn0G |1   |
| 2  | regina@xyz.co.uk  | $2y$10$y.VMTLhVBFKSoeRGxw1LuepteGWKPfAHcQbMXsvnMCijOiZgKegU. |2   |
| 3  | olive@xyz.co.uk   | $2y$10$8TcPukD7mLbuIAXaU..y3O45eahiyWBbcMocYiImyBZHgOc38TcnO |1   |

roles

|id|name         |
|--|-------------|
|1 |customer     |
|2 |administrator|

This is a simple example, we have a one-to-many relationshsip between **roles** and **users**. Alternatively, we might have a many-to-many relationship between user and role and need a junction table.

When the user logs in we can store their role in a session variable.

```php
<?php
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $login = false;
    if($row = $stmt->fetch()){
        if (password_verify($password, $row['password'])) {
          $_SESSION["email"] = $email;
          $_SESSION["role"] = $row['role']; //store the user's role
          header( "Location: index.php" );
        }
    }
?>
```
We can display navigation options based on the user’s role

```php
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="page1.php">Page 1</a></li>
        <li><a href="page2.php">Page 2</a></li>
        <li><a href="page3.php">Page 3</a></li>
        <li><a href="logout.php">Logout</a></li>
        <?php
        if($_SESSION["role"] == 2){
            echo '<li><a href="admin.php">Extra Admin Option</a></li>';
        }
        ?>
    </ul>
</nav>

```
We can protect page content based on the user role.

```php
<?php
if($_SESSION["role"] != 2){
	echo "<p>Only admin can access this page<p>";
	echo "</body>";
	echo "</html>";
	exit;
}
?>

<h1>Admin</h1>
<p>Special admin functions</p>
...

```
