<?php


namespace App\Models;


use App\Http\Config;

class Link extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    public function find($filed_name, $value)
    {
        $this->query = mysqli_query($this->connstr, "SELECT url,slug FROM `" . $this->table . "` WHERE `" . $filed_name . "`='" . $value . "';");
        $result = [];
        while ($res = mysqli_fetch_assoc($this->query)) {
            array_push($result, $res);
        }
        return $result;
    }

    public function insert(array $fields, array $records) {
        $fields = implode(",", $fields);
        $records = implode("','", $records);

        $this->query = "insert into " . $this->table . " ({$fields},created_at, updated_at) values ('{$records}',NOW(),NOW())";
        $this->query = mysqli_query($this->connstr, $this->query);

        CacheFile::flush();
        return true;
    }
}