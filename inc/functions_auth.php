<?php
function isAuthenticated()
{
  //global $session;
  //return $session->get('auth_logged_in', false);
  return decodeAuthCookie('auth_user_id');
}

function requireAuth()
{
  if (!isAuthenticated()) {
    global $session;
    $session->getFlashBag()->add('error', 'Not Authorized');
    redirect('/login.php');
  }
}

function isAdmin()
{
  if (!isAuthenticated()) {
    return false;
  }
  
  //global $session;
  //return $session->get('auth_roles') === 1;
  return decodeAuthCookie('auth_roles') === 1;
}

// function requireAdmin()
// {
//   if (!isAdmin()) {
//     global $session;
//     $session->getFlashBag()->add('error', 'Not Authorized');
//     redirect('/login.php');
//   }
// }

// function isOwner($ownerId)
// {
//   if (!isAuthenticated()) {
//     return false;
//   }
  
//   global $session;
//   return $ownerId == $session->get('auth_user_id');
// }

function getAuthenticatedUser()
{
  //global $session;
  //return findUserById($session->get('auth_user_id'));
  return findUserById(decodeAuthCookie('auth_user_id'));
}

function saveUsersData($user)
{
  global $session;
  // $session->set('auth_logged_in', true);
  // $session->set('auth_user_id', (int) $user['id']);
  // $session->set('auth_roles', (int) $user['role_id']);
  
  $session->getFlashBag()->add('success', 'Successfully Logged In');

  $expTime = time() + 3600;
  $jwt = Firebase\JWT\JWT::encode(
    [
      'iss' => request()->getBaseUrl(),
      'sub' => (int) $user['id'],
      'exp' => $expTime,
      'iat' => time(),
      'nbf' => time(),
      'auth_roles' => (int) $user['role_id']
    ],
    getenv("SECRET_KEY"),
    'HS256'
  );
  $cookie = setAuthCookie($jwt, $expTime);
  //var_dump($cookie); die;
  redirect('/', ['cookies' => [$cookie]]);
}

function setAuthCookie($data, $expTime) {
  $cookie = new Symfony\Component\HttpFoundation\Cookie(
    'auth',
        $data,
        $expTime,
        '/',
        '',
        false,
        true
  );
  return $cookie;
}

function decodeAuthCookie($prop = null)
{
  try {

    Firebase\JWT\JWT::$leeway=1;
    $cookie = Firebase\JWT\JWT::decode(
      request()->cookies->get('auth'),
      getenv("SECRET_KEY"),
      ['HS256']
    );
  } catch (Exception $e) {
    return false;
  }
  if ($prop === null) {
    return $cookie;
  }
  if ($prop == 'auth_user_id') {
    $prop = 'sub';
  }
  if (!isset($cookie->$prop)) {
    return false;
  }
  return $cookie->$prop;
}