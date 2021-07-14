<?php

use App\Http\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        echo $_GET['hi'];
    }

    public function get()
    {
        echo "get";
    }

}