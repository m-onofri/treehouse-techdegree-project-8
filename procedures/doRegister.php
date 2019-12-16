<?php

require_once __DIR__ . '/../inc/bootstrap.php';

//Get user data from the register form
$username = request()->get('username');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

//Check if the password is equal to the confirmPassword
if ($password != $confirmPassword) {
    $session->getFlashBag()->add('error', 'Password do NOT match');
    redirect('/register.php');
}

//Check if the user already exists
$user = findUserByUsername($username);
//If the user already exists, redirect to register page
if (!empty($user)) {
    $session->getFlashBag()->add('error', 'User Already Exists');
    redirect('/register.php');
}

//Hashed the password
$hashed = password_hash($password, PASSWORD_DEFAULT);
//Create a new user
$newUser = createUser($username, $hashed);
$session->getFlashBag()->add('success', 'User Added');
//Save the user data with cookie and JWT
saveUsersData($newUser);
