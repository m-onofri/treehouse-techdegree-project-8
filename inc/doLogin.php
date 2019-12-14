<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$username = request()->get('username');
$password = request()->get('password');

$user = findUserByUsername($username);

if (empty($user)) {
    $session->getFlashBag()->add('error', 'Username was not found');
    redirect('/login.php');
}

if (!password_verify($password, $user['password'])) {
    $session->getFlashBag()->add('error', 'Invalid Password');
    redirect('/login.php');
}

saveUsersData($user);