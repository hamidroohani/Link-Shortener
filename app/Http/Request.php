<?php

namespace App\Http;


class Request
{
    public static function get_param($param)
    {
        return $_GET[$param] ?? $_POST[$param] ?? 'error';
    }
}


