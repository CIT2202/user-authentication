# User Authentication

## If you are using Codespaces

- Open your existing codespace (you shouldn't create a new one) https://github.com/codespaces.
- In the terminal enter
```
git clone https://github.com/CIT2202/user-authentication
```
This will copy the contents of this repository into your codespace.

- If needed, start Apache i.e. enter `apache2ctl start` in the terminal.

Now move onto [Completing the practical work](#practical)

## If you are using XAMPP

- Download the code in this repository (click on the big green button that says 'code')
- Unzip the folder.
- Copy it into the htdocs folder on XAMPP
- Open the folder using your text editor of choice e.g. VS Code

Now move onto [Completing the practical work](#practical)
## Before you start
Make sure you are familiar with the basic ideas to do with maintaining state in a web application, and that you understand what cookies and session are. These [notes](https://github.com/CIT2202/user-authentication/blob/master/sessions-cookies.md) should help you. 

## Completing the practical work <a name="practical"></a>
- The folder xyz is a website with a simple login system.
* Open ```login.php```, ```login_process.php``` in a text editor. See how the login system is working, the email and password from the form are tested and then a session variable is set.
* Login into the website and make sure you can navigate to each of the pages.
* Close the browser and try and go directly to ```index.php``` without logging in. You should find that you can't access this page. 

On your own
* Protect ```page1.php```, ```page2.php``` and ```page3.php``` in the same way that ```index.php``` has been protected. You should be able to cut, copy, paste code from ```index.php```.
* Create a page called ```logout.php```.
   * This should destroy the session and provide a link back to the login form. Add a link to *logout.php* from the other pages in the site. Check this works.
* How can you use the ```header()``` function in PHP to reirect the user automatically so they don't have to click on links. e.g. change the code in ```login_process.php``` so that the user is redirected back to ```login.php``` automatically if they enter the wrong username/password.
* How can you display a message in *login.php* telling the user the login attempt was unsuccessful. 

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

* One weakness of this example is the user has to click a link or use the back button on *login_process.php*. Add redirection to *login_process.php* so that the user is automatically taken to the home page if they enter the correct details, or returned to the login page if they don't.
    * If this works, think about how you can pass a message back to the login page letting the user know they entered the wrong details (use a session variable). 
