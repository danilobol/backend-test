<?php
namespace App\Helpers\Errors;

class ServerErrors {
    const ERROR_1001 = "SERV1001";
    const ERROR_1002 = "SERV1002";


    private static $errors = array(
        self::ERROR_1001 => "Error generic!",
        self::ERROR_1002 => "Error on User Login!",
    );

    public static function getError(string $errorCode){
        return self::$errors[$errorCode];
    }
}
