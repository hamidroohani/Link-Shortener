<?php

namespace App\Models;

use App\Http\Config;

class DB
{
    public $connstr = null;
    public $table = "wp_posts";
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

        $this->query = mysqli_query($this->connstr, "SHOW TABLES LIKE '" . $this->table ."';");
        $result = [];
        while ($res=mysqli_fetch_assoc($this->query)) {
            array_push($result, $res);
        }
        if (!count($result)){
            Response::db_connection_not_exists();
        }
    }
}