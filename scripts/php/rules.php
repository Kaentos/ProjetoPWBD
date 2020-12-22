<?php
    /*define("NAME_MIN_LENGTH", 6);
    define("NAME_MAX_LENGTH", 64);
    
    define("USER_MAX_LENGTH", 16);
    define("PWD_MAX_LENGTH", 64);
    define("ADDRESS_MIN_LENGTH", 6);
    define("ADDRESS_MAX_LENGTH", 128);
    define("CC_VALUE", 6);
    define("CONTACT_VALUE", 9);*/
    define("USER_MIN_LENGTH", 4);
    define("PWD_MIN_LENGTH", 4);
    define("EMAIL_MIN_LENGTH", 6);
    define("EMAIL_MAX_LENGTH", 128);

    /* https://regex101.com/ */
    define("REGEX_USERNAME", "/^[a-zA-Z1-9_]{4,16}$/");
    define("REGEX_EMAIL", "/^[a-zA-Z1-9_.-]{1,64}@{1}[a-z-]{1,32}.{1}[a-z]{2,6}$/");
    define("REGEX_NAME", "/^[a-zA-Z]{2,32} {1}[a-zA-Z]{2,32}$/");
    //define("REGEX_CC", "/^[1-9]{8}$/");
    define("REGEX_CONTACTNUMBER", "/^[1-9]{9}$/");
    // https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a
    define("REGEX_PWD", "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d+!?#$%&_\-.,;]{6,64}$/");
    

    /* https://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format/19271434
    function validateDate($date, $format = "Y-m-d") {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }*/
?>