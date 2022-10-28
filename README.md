# User Authentication
## Before you start
Make sure you are familiar with the basic ideas to do with maintaining state in a web application, and that you understand what cookies and session are. These [notes](https://github.com/CIT2202/user-authentication/blob/master/sessions-cookies.md) should help you. 

## A simple example with a hard-coded password
Download this repository. The folder xyz is a website with a simple login system.
* Open ```login.php```, ```login_process.php``` in a text editor. See how the login system is working, the email and password from the form are tested and then a session variable is set.
* Put the xyz website on a server. Login into the website and make sure you can navigate to each of the pages.
* Close the browser and try and go directly to ```index.php``` without logging in. You should find that you can't access this page. 

On your own
* Protect ```page1.php```, ```page2.php``` and ```page3.php``` in the same way that ```index.php``` has been protected. You should be able to cut, copy, paste code from ```index.php```.
* Create a page called ```logout.php```.
   * This should destroy the session and provide a link back to the login form. Add a link to *logout.php* from the other pages in the site. Check this works.
* How can you use the ```header()``` function in PHP to reirect the user automatically so they don't have to click on links. e.g. change the code in ```login_process.php``` so that the user is redirected back to ```login.php``` automatically if they enter the wrong username/password. 

## Using a database
Clearly, using a hard-coded email and password has major limitations. Next, think about how you can store user details in a database table instead. Have a look through the following [notes](https://github.com/CIT2202/user-authentication/blob/master/authentication_authorisation.md) to familiarise yourself with the basics of authentication and authorisation.

### Hashing passwords
We should never store passwords as plain text. Open *hashing.php* see how PHP generates password hashes.
* Experiment with hashing some more passwords using both *md5()* and *password_hash()*.
* Make sure you understand the difference that adding a salt makes.


### Set up the database table
Using the same database that you have used in previous weeks, execute the SQL statements in [users.sql](users.sql). This will set up a database table containing user emails and passwords.

If you browse this table you will see that the passwords have been hashed. The actual passwords are:-
* ghulam@xyz.co.uk password:huddersfield
* regina@xyz.co.uk password:123456
* olive@xyz.co.uk  password:qwerty

### Modify the login code to use a database
* Modify the code in *login_process.php* so that you test the user's email address and password against the values in the users table. Have a look on the notes/slides from this week for an example e.g. https://github.com/CIT2202/user-authentication/blob/master/authentication_authorisation.md#checking-user-input-against-a-hashed-password.
> If you are having problems getting this to work, temporarily comment out the redirection statements e.g. ```header( "Location: index.php" );``` you will then be able to see errors in login_process.php.

* To test your understanding, add another user to the users table. Invent an email address and a password. Hash this password (like the examples in *hashing.php*). In phpmyadmin use the 'insert' tab to these user details to the database table.  Check you can successfully login using this username/password.
