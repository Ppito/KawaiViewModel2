<?php
/**
 * Validation
 */
class Is {
  
  /**
   * Check is id
   * 
   * @param int|string $value
   * @return boolean
   */
  public static function id($value) {
    return preg_match('#^\w+$#', $value);
  }

  /**
   * Check is md5
   * 
   * @param string $value
   * @return boolean
   */
  public static function md5($value) {
    return preg_match('#^[0-9A-Fa-f]+$#', $value) && strlen($value) == 32;
  }

  /**
   * Check is integer
   * 
   * @param int|string $value
   * @return boolean
   */
  public static function integer($value) {
    return preg_match('#^-?[0-9]+$#', $value);
  }

  /**
   * Check is string
   * 
   * @param string $value
   * @return boolean
   */
  public static function string($value) {
    return is_string($value);
  }

  /**
   * Check is boolean
   * 
   * @param string|boolean $value
   * @return boolean
   */
  public static function bool($value) {
    return preg_match('#^[01]$#', $value);
  }

  /**
   * Check is decimal
   * 
   * @param string $value
   * @return boolean
   */
  public static function decimal($value) {
    return preg_match('#^-?(?:[0-9]+[\.,]?[0-9]*|[0-9]*[\.,]?[0-9]+)$#', $value);
  }

  /**
   * Check is pair
   * 
   * @param int|string $value
   * @return boolean
   */
  public static function pair($value) {
    return (!($value % 2));
  }

  /**
   * Check is numeric
   * 
   * @param int $value
   * @return boolean
   */
  public static function alphaNumerique($value) {
    return preg_match('#^\w*$#', $value);
  }

  /**
   * Check is blank
   * 
   * @param int $value
   * @return boolean
   */
  public static function blank($value) {
    return (trim($value) == "");
  }

  /**
   * Check is date format dd/mm/yyyy
   * 
   * @param string $value
   * @return boolean
   */
  public static function date($value) {
    $resultat = array();
    $resultat = preg_split('|[/.-]|', $value);
    if (count($resultat) == 3) {
      $day   = $resultat[0];
      $month = $resultat[1];
      $year  = $resultat[2];
      if (Is::integer($day) && Is::integer($month) && Is::integer($year)) {
        if (strlen($year) == 2)
          $year = '20' . $year;
        return checkDate($month, $day, $year);
      }
    }
    return false;
  }

  /**
   * Check is date format yyyy/mm/dd
   * 
   * @param string $value
   * @return boolean
   */
  public static function dateUk($value) {
    $resultat = array();
    $resultat = preg_split('|[/.-]|', $value);
    if (count($resultat) == 3) {
      $year  = $resultat[0];
      $month = $resultat[1];
      $day   = $resultat[2];
      if (Is::integer($day) && Is::integer($month) && Is::integer($year)) {
        if (strlen($year) == 2)
          $year = '20' . $year;
        return checkDate($month, $day, $year);
      }
    }
    return false;
  }

  /**
   * Check is date time format yyyy/mm/dd H:i:s
   * 
   * @param string $value
   * @return boolean
   */
  public static function dateTime($value) {
    $resultat = array();
    $resultat = preg_split('|\ |', $value);
    if (count($resultat) == 2) {
      if (!Is::dateUk($resultat[0])) {
        return false;
      }
      $matches = array();
      if (preg_match('#(\d{2})\:(\d{2})\:(\d{2})#', $resultat[1], $matches)) {
        if (!isset($matches[0]) || $matches[0] > 23 || $matches[0] < 0)
          return false;
        if (!isset($matches[1]) || $matches[1] > 59 || $matches[1] < 0)
          return false;
        if (!isset($matches[2]) || $matches[2] > 59 || $matches[2] < 0)
          return false;
        return true;
      }
    } else if (count($resultat) == 1) {
      return Is::dateUk($resultat[0]);
    }
    return false;
  }
  
  /**
   * Check is mail
   * 
   * @param string $value
   * @return boolean
   */
  public static function mail($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  /**
   * Check is europeen phone number
   * 
   * @param string $value
   * @return boolean
   */
  public static function phone($value) {
    return preg_match('#^(\+){0,1}(\d|\s|\(|\)){10,20}$#i', $value);
  }

  /**
   * Check is an hour
   * 
   * @param string $value
   * @return boolean
   */
  public static function hour($value) {
    return preg_match('#(?:0+[0-9]|1[0-9]|2[0-3]):(?:[0-5][0-9])#', $value);
  }
}
?>
