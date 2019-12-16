<?php
require_once __DIR__ . '/../inc/bootstrap.php';

//Get current password and new password
$current_password = request()->get('current_password');
$password = request()->get('password');
$confirm_password = request()->get('confirm_password');

//Get user data
$user = findUserById(decodeAuthCookie('auth_user_id'));

//Check if the current password is correct
if (!password_verify($current_password, $user['password'])) {
    $session->getFlashBag()->add('error', 'The old password is not correct');
    redirect('/account.php');
}

//Check if the new password is equal to the new confirmed password
if ($password !== $confirm_password) {
    $session->getFlashBag()->add('error', 'Passwords are not correct');
    redirect('/account.php');
}

//Hash the new password 
$hashed = password_hash($password, PASSWORD_DEFAULT);
//Update the new password
updatePassword($hashed, $user['id']);
$session->getFlashBag()->add('success', 'Password is updated successfully');
//redirect to the index page
redirect('/index.php');
