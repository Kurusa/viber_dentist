<?php

namespace App\ViberHelpers;

class ViberParser {

    private static $data;

    public function __construct($data)
    {
        self::$data = $data;
    }

    public static function getUserName()
    {
        return self::$data['sender']['name'];
    }

    public static function getMessage()
    {
        return self::$data['message']['text'];
    }

}