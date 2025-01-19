<?php
$password = 'developer2025'; // Replace 'developer2025' with your desired password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;
?>