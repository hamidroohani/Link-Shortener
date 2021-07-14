<?php


namespace App\Models;


use App\Http\Config;

class Token extends DB
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "tokens";
        $this->query = "select * from " . $this->table . " where 1 ";
    }

    public function where($field, $opr, $val)
    {
        $this->query .= " and {$field} {$opr} '{$val}'";

        return $this;
    }

    public function get()
    {
        $this->query = mysqli_query($this->connstr, $this->query);
        $result = [];
        while ($res=mysqli_fetch_assoc($this->query)) {
            array_push($result, $res);
        }

        return $result;
    }

    public function insert(array $fields, array $records,$user_id) {
        mysqli_query($this->connstr, "DELETE FROM " . $this->table . " WHERE user_id = " . $user_id);
        $fields = implode(",", $fields);
        $records = implode("','", $records);

        $this->query = "insert into " . $this->table . " ({$fields}) values ('{$records}')";
        $this->query = mysqli_query($this->connstr, $this->query);

        return true;
    }
}