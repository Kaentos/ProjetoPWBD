<?php
    /*define("NAME_MIN_LENGTH", 6);
    define("NAME_MAX_LENGTH", 64);
    define("EMAIL_MIN_LENGTH", 6);
    define("EMAIL_MAX_LENGTH", 128);
    define("USER_MAX_LENGTH", 16);
    define("PWD_MAX_LENGTH", 64);
    define("ADDRESS_MIN_LENGTH", 6);
    define("ADDRESS_MAX_LENGTH", 128);
    define("CC_VALUE", 6);
    define("CONTACT_VALUE", 9);*/
    define("USER_MIN_LENGTH", 4);
    define("PWD_MIN_LENGTH", 4);

    /* https://regex101.com/ */
    define("REGEX_USERNAME", "/^[a-zA-Z1-9_]{4,16}$/gm");
    define("REGEX_NAME", "/^[a-zA-Z ]{6,64}$/gm");
    define("REGEX_CC", "/^[1-9]{8}$/gm");
    define("REGEX_CONTACTNUMBER", "/^[1-9]{9}$/gm");
    /* https://stackoverflow.com/questions/8141125/regex-for-password-php */
    define("REGEX_PWD", "/^\S*(?=\S{6,64})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/gm");
    

    /* https://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format/19271434 */
    function validateDate($date, $format = "Y-m-d") {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
?>