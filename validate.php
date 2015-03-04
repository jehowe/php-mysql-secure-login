<?php

require '/var/www/include/database.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $con->prepare("SELECT passwd FROM registration WHERE username=?");
$stmt->bind_param('s', $username);
$stmt->bind_result($password_hash);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if (password_verify($password, $password_hash))  {
$response["result"] = 1;
$response["msg"]    = "validated";
echo json_encode($response);
}else{
$response["result"] = 2;
$response["msg"]    = "login incorrect";
echo json_encode($response);
}
exit();
?>
