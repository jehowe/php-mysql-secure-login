# php-mysql-secure-login
A secure user web login platform using PHP and MySQL

This is a minimalist (and highly adaptable/expandable) web user/password creation & login system that securely creates, stores,
and authenticates using hashes derived from the current best practice Blowfish encryption cipher.  The hash
is iterated 10 rounds (adjust to meet your server requirements) and salted, making this an extremely strong
one-way hashing algorithm.

Password hashes are created then tested against the password for consistensy before the username and password hash is stored in database.  I don't have to expain why storing actual passwords is bad....  The user/passwd combination can then be checked via the browser using the validate.html file.

Use you own needs and imagination to extend this into a web based user account manager.

Requirements: Webserver, and PHP (PHP version minimum 5.4, 5.5 preferred), MySQL database, setup with a minimum of one
table with fields to hold usernames and password hashes.

Webserver files:  registration.html (new user webform), registration.php (script that creates p/w hash, queries database),
validate.html (login webform), validate.php (runs password against the stored hash in the database), not listed is the database connection file referenced in the .php files- please create your own and DO NOT store this file in the webservers root directory!

