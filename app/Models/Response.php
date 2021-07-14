<?php


namespace App\Models;


class Response
{
    public static function db_connection_not_exists()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        header('Content-Type: application/json');
        exit(json_encode(
            [
                'status' => false,
                "message" => "An error occurred while connecting, please check your database information in Config.php file"
            ]
        ));
    }
}