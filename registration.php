<?php

// minimal secure PHP login registration hash/check file
// author: jeff howe jeff@jhowe.net

// require database auth file - uncomment and modify the line below
require '/var/www/include/database.php';

$username = $_POST['username'];
$password = $_POST['password'];

/* ***uncomment and use this code block if the server is running PHP 5.4***

// create function to create hash, forcing the use of blowfish encryption, rounds = 7, increase if the server can handle it
function better_crypt($input, $rounds = 7)   // force the encryption to use blowfish, w/ 22 char salt & 7 rounds
{
$salt = "";
$salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
for($i=0; $i < 22; $i++) {
$salt .= $salt_chars[array_rand($salt_chars)];
}
return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
}

// send the password to the hash function and save as string
$password_hash = better_crypt($password);

// check username to see if user exists - modify query to fit db structure
$stmt = $con->prepare("SELECT COUNT(*) FROM registration WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->bind_result($count);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if ($count > 0)  {
// username exists, exit script
$response["result"] = 2;
$response["msg"]    = $username." already taken";
echo json_encode($response);
exit();
}else{
// good so far, check hash to ensure hash is consistent with password
if(crypt($password, $password_hash) == $password_hash) {
// password is consistent with hash, store in db using prepared statement- modify query as needed
$stmt = $con->prepare("INSERT INTO registration (username, passwd) VALUES (?, ?)");
$stmt->bind_param('ss', $username, $password_hash);
$stmt->execute();
$stmt->close();
// echo success result - json in this example, modify as needed
$response["result"] = 1;
$response["msg"]    = "success";
echo json_encode($response);
}else{
// echo password->hash problem, password will require re-hashing
$response["result"] = 3;
$response["msg"]    = "hash inconsistency";
echo json_encode($response);
}
}
*/

// the code below is for servers running PHP 5.5
// create function to ensure use of blowfish encryption to generate hash- rounds=10
function better_crypt($input, $rounds = 10)
{
    $crypt_options = array(
        'cost' => $rounds
    );
    return password_hash($input, PASSWORD_BCRYPT, $crypt_options);
}

// send password to hashing function and save as string var
$password_hash = better_crypt($password);

// check username to see if user exists - modify query to fit db structure
$stmt = $con->prepare("SELECT COUNT(*) FROM registration WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->bind_result($count);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    // username exists, exit script
    $response["result"] = 2;
    $response["msg"]    = $username . " already taken";
    echo json_encode($response);
    exit();
} else {
    // looking good so far
    // test hash consistency with password using PHP's built in 'password_verify' function
    if (password_verify($password, $password_hash)) {
        // password is consistent with hash, store in db using prepared statement- modify query as needed
        $stmt = $con->prepare("INSERT INTO registration (username, passwd) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $password_hash);
        $stmt->execute();
        $stmt->close();
        // echo success result - json in this example, modify as needed
        $response["result"] = 1;
        $response["msg"]    = "success";
        echo json_encode($response);
    } else {
        // echo password->hash problem, password will require re-hashing
        $response["result"] = 3;
        $response["msg"]    = "hash inconsistency";
        echo json_encode($response);
    }
}

exit();

?>
