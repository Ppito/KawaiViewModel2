<?php

class Form {

  /**
   * Create input form
   * 
   * @param string $name
   * @param string $type
   * @param string $value
   * @param string $id
   * @param array  $params
   * @return string
   */
  public static function input($name, $type = 'text', $value = '', $id = '', array $params = array()) {
    $res = '<input name="' . $name . '" type="' . $type . '"';

    if (!empty($value)) {
      if (is_array($value)) {
        $tab = $value;
        $value = $_SESSION;
        foreach ($tab as $col) {
          if (array_key_exists($col, $value) && !empty($value[$col])) {
            $value = $value[$col];
          }
        }
        if (is_array($value))
          $value = '';
      }
      $res .= ' value="' . htmlspecialchars($value) . '"';
    }
    if (!empty($id))
      $res .= ' id="' . $id . '"';
    if (!empty($params)) {
      foreach ($params as $key => $val) {
        if (!empty($val))
          $res .= ' ' . $key . '="' . $val . '"';
      }
    }
    $res .= ' />';
    return $res;
  }

  /**
   * Create radio form
   * 
   * @param string  $name
   * @param array   $option
   * @param string  $checked
   * @param boolean $multiLine
   * @param string  $id
   * @return string
   */
  public static function radio($name, array $options, $checked = '', $multiLine = false, $id = '') {
    if (!is_array($options))
      return false;

    $res = '';
    foreach ($options as $option => $params) {
      $res .= '<input name="' . $name . '" type="radio"';
      if (!empty($id)) {
        $res .= ' id="' . $id . '"';
        if (array_key_exists('id', $params))
          unset($params['id']);
      }

      if (!empty($params)) {
        foreach ($params as $key => $val) {
          if (!empty($val) && $key != 'label')
            $res .= ' ' . $key . '="' . $val . '"';
        }
      }

      $res .= ' value="' . $option . '"';

      if (is_array($checked)) {
        $tab = $checked;
        $checked = $_SESSION;
        foreach ($tab as $col) {
          if (array_key_exists($col, $checked) && !empty($checked[$col])) {
            $checked = $checked[$col];
          }
        }
      }

      if ($option == $checked)
        $res .= ' checked="checked"';
      $res .= ' />';

      if (array_key_exists('label', $params)) {
        if (array_key_exists('id', $params)) {
          $res .= '<label for="' . $params['id'] . '">' . htmlspecialchars($params['label']) . '</label>';
        } else {
          $res .= htmlspecialchars($params['label']);
        }
      }
      if ($multiLine === true)
        $res .= "<br />";
      $res .= "\n";
    }
    return $res;
  }

  /**
   * Create select form
   * 
   * @param string $name
   * @param array  $option
   * @param string $selected
   * @param string $id
   * @param array  $params
   * @return string
   */
  public static function select($name, array $options, $selected = '', $id = '', array $params = array()) {
    $res = '<select name="' . $name . '"';
    if ($id != '')
      $res .= ' id="' . $id . '"';
    if (!empty($params)) {
      foreach ($params as $key => $val) {
        $res .= ' ' . $key . '="' . $val . '"';
      }
    }
    $res .= '>' . "\n";
    foreach ($options as $key => $val) {
      $res .= '<option value="' . $key . '"';
      if ($val == $selected)
        $res .= ' selected="selected"';
      $res .= '>' . htmlspecialchars($val) . '</option>' . "\n";
    }
    $res .= '</select>';
    return $res;
  }

  /**
   * Create textarea form
   * 
   * @param string $name
   * @param array  $value
   * @param string $id
   * @param array  $params
   * @return string
   */
  public static function textarea($name, $value = '', $id = '', array $params = array()) {
    $res = '<textarea name="' . $name . '"';
    if ($id != '')
      $res .= ' id="' . $id . '"';
    if (!empty($params)) {
      foreach ($params as $key => $val) {
        $res .= ' ' . $key . '="' . $val . '"';
      }
    }
    $res .= ">";
    $res .= $value;
    $res .= "</textarea>";
    return $res;
  }

  /**
   * Check form validity
   * 
   * @param array  $field
   * @param array  $params
   * @return array|true
   */
  public static function check(array $field, array $params) {
    $errors = array();
    $errorsField = array();
    $errorsCustom = array();

    foreach ($field as $col => $options) {
      $type = $options['type'];
      if (array_key_exists('required', $options) && $options['required'] == true && Is::blank($params[$col])) {
        array_push($errors, $options['error']);
      } elseif (!Is::blank($params[$col]) && !Is::$type($params[$col])) {
        array_push($errorsField, $options['error']);
      } elseif (!Is::blank($params[$col]) && array_key_exists('sameField', $options) && $params[$col] != $params[$options['sameField']['field']]) {
        array_push($errorsCustom, $options['sameField']['error']);
      }
    }
    if (count($errors) > 0 || count($errorsField) > 0 || count($errorsCustom) > 0) {
      return array('errors' => $errors, 'errorsField' => $errorsField, 'errorsCustom' => $errorsCustom);
    }
    return true;
  }

}
?>