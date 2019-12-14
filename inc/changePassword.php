<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$current_password = request()->get('current_password');
$password = request()->get('password');
$confirm_password = request()->get('confirm_password');

$user = findUserById($session->get('auth_user_id'));

//var_dump(password_verify($current_password, $user['password'])); die;

if (!password_verify($current_password, $user['password'])) {
    $session->getFlashBag()->add('error', 'The old password is not correct');
    redirect('/account.php');
}

if ($password !== $confirm_password) {
    $session->getFlashBag()->add('error', 'Passwords are not correct');
    redirect('/account.php');
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
updatePassword($hashed, $user['id']);

redirect('/index.php');
