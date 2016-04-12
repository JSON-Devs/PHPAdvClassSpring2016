<?php

/**
 * Description of Validation
 *
 * @author 001349718
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
        return ( preg_match('/^[-a-zA-Z0-9~!$%^&*_=+}{\'?]+(\.[-a-zA-Z0-9~!$%^&*_=+}{\'?]+)*@([a-zA-Z0-9_][-a-zA-Z0-9_]*(\.[-a-zA-Z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/', $email));
    }
}
