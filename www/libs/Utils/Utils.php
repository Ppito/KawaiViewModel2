<?php

/**
 * Some utils function 
 */
class Utils
{
  /**
   * change FR date to UK date
   * 
   * @param string $date
   * @return string|false
   */
  public static function dateFrToUk($date)
  {
    if (!empty($date)) {
      list($day, $month, $year) = explode('/', $date);
      if ( $day && $month && $year )
        return "{$year}-{$month}-{$day}";
      else
        return $date;
    }
    return false;
  }

  /**
   * change UK date to FR date
   * 
   * @param string $date
   * @return string|false
   */
  public static function dateUkToFr($date)
  {
    if (!empty($date)) {
      list($year, $month, $day) = explode('-', $date);
      if ( $year && $month && $day )
        return "{$day}/{$month}/{$year}";
      else
        return $date;
    }
    return false;
  }

  /**
   * Format inputForm error
   * 
   * @param array $errors
   * @return array
   */
  public static function formatError(array $errors = array())
  {
    $res = array();
    if ( array_key_exists('errors', $errors) && count($errors['errors']) > 0)
      $res[] = ((count($errors['errors']) > 1) ? _("Les champs suivants sont obligatoire : ") : _("Le champ suivant est obligatoire : ")) . implode(', ', $errors['errors']).'.';
    if ( array_key_exists('errorsField', $errors) && count($errors['errorsField']) > 0)
      $res[] = ((count($errors['errorsField']) > 1) ? _("Les champs suivants sont invalides : ") : _("Le champ suivant est invalide : ")) . implode(', ', $errors['errorsField']).'.';
    if ( array_key_exists('errorsCustom', $errors) && count($errors['errorsCustom']) > 0)
      $res[] = implode('<br />', $errors['errorsCustom']);
    return $res;
  }

  /**
   * Change string with underscore to camel case
   * 
   * @param string $chaine
   * @return string
   */
  public static function CamelCase($chaine)
  {
    return lcfirst(self::fuCamelCase($chaine));
  }
  
  /**
   * Change string with underscore to camel case
   * And put first letter in upper
   * 
   * @param string $chaine
   * @return string
   */
  public static function fuCamelCase($chaine)
  {
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $chaine)));
  }
  
  /**
   * Change camel case to string separate with underscore
   * 
   * @param string $chaine
   * @return string
   */
  public static function undoCamelCase($chaine)
  {
    return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1_$2', $chaine));
  }
}

?>