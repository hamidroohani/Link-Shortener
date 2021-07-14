<?php

namespace App\Models;

use App\Http\Config;

class DB
{
    public $connstr = null;
    public $table = "links";
    public $query = null;

    public $hostname = null;

    public function __construct()
    {
        $this->connstr = mysqli_connect(Config::HOSTNAME, Config::USERNAME, Config::PASSWORD, Config::DBNAME);
    }

    public function check_table_exists()
    {
        if (!$this->connstr){
            Response::db_connection_not_exists();
        }
    }
}