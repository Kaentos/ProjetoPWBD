<?php
    define("USER_MIN_LENGTH", 4);
    define("PWD_MIN_LENGTH", 4);
    define("EMAIL_MIN_LENGTH", 6);
    define("EMAIL_MAX_LENGTH", 128);

    /* https://regex101.com/ */
    define("REGEX_USERNAME", "/^(?=.+[a-zA-Z])[a-zA-Z0-9_]{4,16}$/");
    define("REGEX_EMAIL", "/^[a-zA-Z0-9_.-]{1,64}@{1}[a-z-]{1,32}.{1}[a-z]{2,6}$/");
    define("REGEX_NAME", "/^[a-zA-Z]{2,32} {1}[a-zA-Z]{2,32}$/");
    define("REGEX_CONTACTNUMBER", "/^[0-9]{9}$/");
    // https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a
    define("REGEX_PWD", "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d+!?#$%&_\-.,;]{4,64}$/");
    define("REGEX_PLATE", "/^[A-Z0-9]{6}$/");
    
    define("USER_TYPE_ADMIN", 1);
    define("USER_TYPE_INSPECTOR", 2);
    define("USER_TYPE_CLIENT", 3);
    define("USER_TYPE_DELETED", 0);
?>