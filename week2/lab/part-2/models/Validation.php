<?php

/**
 * Description of Validation
 *
 * @author JAYGAGS
 */
class Validation {
    /**
     * A method to check if the field is filled in.
     *
     * @param {String} [$item] - must be a valid string combination
     *
     * @return boolean
     */
    public function filledIn($item) {
        return ( preg_match('/^(?:[A-Za-z0-9]+)(?:[A-Za-z0-9 _]*)$/', $item));
    }
    
    /**
     * A method to check if a zip code is valid.
     *
     * @param {String} [$email] - must be a valid zip code
     *
     * @return boolean
     */
    public function zipIsValid($zip) {
        return ( preg_match('/^[0-9]{5}(?:-[0-9]{4})?$/', $zip));
    }
    
    /**
     * A method to check if an email is valid.
     *
     * @param {String} [$email] - must be a valid email
     *
     * @return boolean
     */
    public function emailIsValid($email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}
