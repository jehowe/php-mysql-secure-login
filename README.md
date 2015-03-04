# php-mysql-secure-login
A secure user web login platform leveraging PHP and MySQL

This is a minimalist (and highly adaptable/expandable) web user/password creation & login system that securely creates, stores,
and authenticates using hashes derived from the current best practice Blowfish encryption cipher.
Password hashes are created using PHP's bcrypt function, tested against the password for consistensy,
then the username and password hash is stored in database.  I don't have to expain why storing actual passwords is bad....

Requirements: Webserver supporting PHP (PHP version minimum 5.4, 5.5 preferred), MySQL database, setup with a minimum of one
table with fields to hold usernames and password hashes.

Webserver files:  registration.html (new user webform), registration.php (script that creates p/w hash, queries database),
validate.html (login webform), validate.php (runs password against the stored hash in the database), not listed is the database connection file referenced in the .php files- please create your own and DO NOT store this file in the webservers root directory!

