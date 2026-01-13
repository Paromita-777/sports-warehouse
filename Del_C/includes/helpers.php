<?php
 /**
 * Set an HTML-safe 'value' attribute of a form field.
 * This uses getEncodedValue() to handle session or $_POST values.
 * prioritizing session data if available (e.g., after form validation errors).
 *
 * @param string $fieldName The name of the field.
 * @return string The 'value' attribute string ready for HTML output.
 */

  function setValue(string $fieldName): string
  {
    // Get HTML-encoded value from session or POST
    $fieldValue = getEncodedValue($fieldName);

    // Return the value attribute with safely encoded content
    return " value='$fieldValue'";
  }
  /**
 * Get an HTML-encoded value for a field.
 * 
 * * Priority order:
 * 1. Session-stored old input value (e.g., after failed validation)
 * 2. $_POST data if session value is not set
 * 3. Empty string if neither is set
 *
 * @param string $fieldName The name of the form field.
 * @return string HTML-safe value.
 */
  function getEncodedValue(string $fieldName): string
  {
     $fieldValue  = $_SESSION['contactFormInputs'][$fieldName] 
            ?? $_POST[$fieldName]
            ?? "";

    // Safely encode the value for HTML output to prevent XSS
    return htmlspecialchars($fieldValue);
  }

  /**
 * Get the raw (unescaped) form value from session or POST.
 * Priority:
 * 1. Session-stored value if available
 * 2. $_POST value if no session value
 * 3. Empty string if neither present
 *
 * This function is intended for comparing raw values (e.g., in setChecked/setSelected).
 *
 * @param string $fieldName The name of the form field.
 * @return string The raw form value.
 */

  function getFormValue(string $fieldName): string
  {
    return $_SESSION['contactFormInputs'][$fieldName] 
          ?? $_POST[$fieldName] 
          ?? "";
  }

   /**
   * Return the "checked" attribute if the form field's value matches the provided value.
   * Checks session value first, then falls back to POST data.
   *
   * @param string $fieldName The name of the checkbox/radio field.
   * @param string $fieldValue The value of the field to compare against.
   * @return string The "checked" attribute if the field value matches, otherwise empty string..
   */
  function setChecked(string $fieldName, string $fieldValue): string
  {
    return getFormValue($fieldName) === $fieldValue ? "checked" : "";
  }

  /**
 * Return the "selected" attribute if the form field's value matches the provided value.
 * Checks session value first, then falls back to POST data.
 *
 * @param string $fieldName The name of the select field.
 * @param string $fieldValue The value to compare against.
 * @return string "selected" if the field's current value matches, otherwise empty string.
 */
  function setSelected(string $fieldName, string $fieldValue): string
  {
    
      return getFormValue($fieldName) === $fieldValue ? "selected" : "";
  }
?>