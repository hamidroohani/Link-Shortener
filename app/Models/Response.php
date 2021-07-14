<?php


namespace App\Models;


use App\Http\Config;

class Response
{
    public static function db_connection_not_exists()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        header('Content-Type: application/json');
        exit(json_encode(
            [
                'status' => false,
                "message" => "An error occurred while connecting, please read the readme file"
            ]
        ));
    }

    public static function table_not_exists()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        header('Content-Type: application/json');
        exit(json_encode(
            [
                'status' => false,
                "message" => "Your database connection is exists but the tables are not exists, please read the readme file"
            ]
        ));
    }

    public static function not_valid_url()
    {
        header('HTTP/1.0 400 BAD REQUEST');
        header('Content-Type: application/json');
        exit(json_encode(
            [
                'status' => false,
                "message" => "Your input url is not valid"
            ]
        ));
    }

    public static function success($slug)
    {
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        exit(json_encode(
            [
                'status' => true,
                "message" => "The new url is " . Config::SITE_URL . $slug
            ]
        ));
    }

    public static function not_found()
    {
        http_response_code(404);
        header('Content-Type: application/json');
        exit(json_encode(
            [
                'status' => false,
                "message" => "The page that you are looking for was not found!"
            ]
        ));
    }

    public static function param_not_found()
    {
        header('HTTP/1.0 400 BAD REQUEST');
        header('Content-Type: application/json');
        exit(json_encode(
            [
                'status' => false,
                "message" => "You must call post method and send a parameter with link name"
            ]
        ));
    }
}