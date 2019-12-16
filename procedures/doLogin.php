<?php
require_once __DIR__ . '/../inc/bootstrap.php';

//Get the user data from the login page
$username = request()->get('username');
$password = request()->get('password');

//Get user data from the database
$user = findUserByUsername($username);

//If the user doesn't exists, redirect to login page
if (empty($user)) {
    $session->getFlashBag()->add('error', 'Invalid username and/or password');
    redirect('/login.php');
}

//Check if the password is valid
if (!password_verify($password, $user['password'])) {
    $session->getFlashBag()->add('error', 'Invalid username and/or password');
    redirect('/login.php');
}

//Save the user data in a cookie
saveUsersData($user);