<?php
require_once __DIR__ . '/../inc/bootstrap.php';

//Delete cookie and redirecti to login page
$cookie = setAuthCookie('expired', 1);
$session->getFlashBag()->add('success', 'Successfully Logged Out');
redirect('/login.php', ['cookies' => [$cookie]]);