<?php
/*Check if the user is authenticated.*/
function isAuthenticated()
{
  return decodeAuthCookie('auth_user_id');
}

//Return the user Id
function getAuthenticatedUser()
{
  return findUserById(decodeAuthCookie('auth_user_id'));
}

//Save the user data with cookie and JWT
function saveUsersData($user)
{
  global $session;
  
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
  redirect('/', ['cookies' => [$cookie]]);
}

//Create and set the cookie
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

//Extract user data from the cookie
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