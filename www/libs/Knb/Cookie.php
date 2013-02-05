<?php

class Knb_Cookie
{
  const COOKIE_NAME        = 'session_id';
  const COOKIE_EXPIRE_DAYS = 30;

  public static function createCookie($session_key) 
  {
    setcookie(
      self::COOKIE_NAME,
      $session_key,
      time() + 60*60*24*self::COOKIE_EXPIRE_DAYS,
      ROOT_URL
    );
  }

  public static function getSessionIdFromCookie() 
  {
    if (array_key_exists(self::COOKIE_NAME, $_COOKIE))
      return $_COOKIE[self::COOKIE_NAME];
  }

  public static function generateSessionKey() 
  {
    return md5(uniqid(rand(), true));
  }

}