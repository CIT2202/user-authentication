# Cookies and Sessions
## The Web is Stateless
The web is described as being 'stateless'. We say that HTTP, the basic communication system between browsers and web servers, is a 'stateless protocol'.

This means that by default the web server doesn't store data about the user as they move through a website.

To illustrate this point have a look at the following simple PHP website

page1.php

```php
...
<body>
<?php
$username = "Matthew";
echo "Welcome {$username}.</p>"; //Welcome Matthew
echo "<a href='page2.php'>Go to page 2</a>";
?>
</body>
</html>
```

page2.php

```php
…
<body>
<?php
echo "You are logged in as {$username}</p>"; //Notice: Undefined variable: username
?>
</body>
</html>
```
If the user visits *page1.php* first they will receive a message **Welcome Matthew**. If they then click on the link to page2.php they receive an error message **Notice: Undefined variable: username in page2.php on line 8**

PHP doesn't recognise the variable ```$username```. This is because the server doesn't remember information between pages in a site. It doesn't maintain state.

## We need to maintain state
We need to maintain state in web applications. Here are some examples:
* We need to remember users that have successfully logged into our website.
* If we are building an e-commerce website, we need to remember which products users have put in their shopping baskets.

## How can we pass data between different pages?

Based on what we know so far the only technique we have is using a querystring e.g.

page1.php
```php
…
<body>
<?php
$username = "Matthew";
echo "Welcome {$username}</p>";
echo "<a href='page2.php?username={$username}'>Go to page 2</a>";
?>
</body>
</html>
```

page2.php
```php
…
<body>
<?php
$username = $_GET["username"]; //get the username from the querystring
echo "You are logged in as {$username}</p>";
?>
</body>
</html>
```
This has obvious limitations:-
  * Security. All the data is visible in the URL.
  * Amount of data.
  * Ease of use.

Instead there are two methods that we can also use maintain state in a web application.
* Cookies
* Sessions

## Cookies
A cookie is a simple text file that is stored on the client machine.
* The first time the user visits the web site PHP instructs the browser to set the cookie on the user's machine.
* Even when the user has left the web site the cookie remains on the user's hard drive.
* The next time the user visits the same web site.
    * The browser looks to see if any cookies have been set for this website.
    * If there are matching cookies, the cookie data is sent to the server.
    * PHP reads the cookie and can customise content for the user.

### What does a cookie look like?
We can view the cookies that have been set by different websites e.g. in Chrome *settings > content settings > cookie*s.

A cookie consists of
* A name. A name we assign for the cookie.
* A value. The actual data we want to store.
* An expiry date. When the cookie will be deleted.
* A path. Which pages in the site can access the cookie data.   


Here's an example:

* **Name**: BBC-UID
* **Value**: a42f7c6ffc25b8be38d2e9b0813928e0e55f71674eb8e3b973352aed880968480Mozilla%2f5%2e0%20%28
* **Expires**: Thursday, 6 June 2022 22:03:10
* **Path**: /


This cookie was set by the BBC website. It is storing a user id (the big long string). It can be accessed by any pages in bbc.co.uk (path = /) and it expired on June 2022.

### Cookies in PHP
Here's how cookies work in PHP.

page1.php
```php
<?php
setcookie("fav_colour", "blue", time() + 60*15 , "/");
?>
```
page2.php
```php
<?php
if(isset($_COOKIE['fav_colour'])){
        echo "Your favourite colour is {$_COOKIE['fav_colour']}";
}
?>
```

The ```setcookie``` function is used to create a cookie.
```php
setcookie("name", "value", expiry date , "path");

```
Most of the arguments are self explanatory. For the expiry date in *page1.php* we get the current time ```time()``` and add 15 minutes (60 x 15). So the cookie will expire in 15 minutes time.

To read data stored in cookies we use the ```$_COOKIE``` variable. This is an array (like ```$_POST``` and ```$_GET```). We can access the cookie values by using the name of the cookie as a key e.g. ```$_COOKIE['fav_colour']```.

The cookie will be deleted automatically by the browser at the expiry time. Alternatively we can delete a cookie by setting it's expiry date to be in the past e.g.

```php
<?php
setcookie("fav_colour", "", time()-3600 , "/");
?>
```
### Third party cookies
A security limitation of cookies is we can only read cookies from the same domain e.g. if www.bbc.co.uk sets a cookie then www.hud.ac.uk can’t read this cookie.

Some webpages contain content that comes from a different domain e.g. advertising banners, social media buttons. This content can set cookies. These are called 3rd party cookies and it is one of the ways in which user activity can be tracked between different websites.

### Use cases for cookies
Cookie main benefit is they allow us to store information about users between **separate** website visits.
* The user visits a site. We set a cookie on the user's machine.
* A month later they visit the same site. We can read the cookie and provide personalised content for the user.

### Limitations of cookies
* Security
  * Cookie content is stored in easily accessible text files.
* Users can turn cookies off / reject cookies using settings in their browser.
* Cookies can only store data as simple **name=value** pairs.
* In many countries there is a legal requirement for websites to obtain consent from users before setting cookies. This isn't a huge issue but does create extra work for web developers.

## Sessions
Sessions are used to store information about the user during a **single** website visit.

As the user browses a site we can use sessions to keep track of data such as a user's username, their role e.g. admin/ customer, or products they have added to a shopping basket.

This data is temporary. As soon as the user the closes the browser window the information is deleted.

### How do sessions work?
Sessions work by generating a unique session ID for each website visitor. We can then store data under this session ID. Have a look at the following simple example:

```php
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Sessions Example</title>
</head>

<body>
<?php
$_SESSION["message"]="Welcome to sessions";
echo "Session data has been set";
?>
…
</body>
</html>
```
To use sessions in PHP we call the ```session_start()``` function. This will look to see if there is already a session ID for this user. If there is, PHP will retrieve the existing session data. If there isn't, PHP will generate a new session ID.
* The call to ```session_start()``` must be the first line in any page that uses sessions!
* Note that we never have to deal with the session ID. This is all handled in the background for us by PHP.

To start storing data in a session we use the ```$_SESSION``` variable. This is an associative array that we can use to store any data we want. e.g.

```php
$_SESSION["message"]="Welcome to sessions";
```

We can then retrieve this data in a different page e.g.

page2.php
```php
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Sessions Example – Page 2</title>
</head>

<body>
<?php
if(isset($_SESSION["message"]))
{
	echo "<p>{$_SESSION["message"]}</p>"; //Welcome to sessions
}else{
	echo "No session data to read";
};
?>
…
</body>
</html>

```
Note that we have to call ```session_start()``` again at the top of the page. This is the instruction that we want to use sessions.

We can also delete all session data. For example, if the user wanted to logout.

page3.php
```php
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Sessions Example – Page 3</title>
</head>

<body>
<?php
session_destroy();
echo "The session has been destroyed";
?>
…
</body>
</html>
```
The function ```session_destroy``` simply deletes all session data.

### How does PHP know if there is an existing session ID?
The first time a session ID is created, it is sent to the browser as a cookie. We call this a **session cookie**.

This cookie will then be sent to PHP every time the user requests a new page from the site. This lets PHP know that a session ID has been set and it needs to look up data on the server using this session ID.

The key point is that it is only the session ID that is sent to the browser, the actual session data is stored securely on the server.

If the user has cookies turned off in their browser, then PHP will use the query string to pass the session ID from page to page.
