<?php

use App\Http\BaseController;

class LinkController extends BaseController
{
    public function index()
    {
        echo generateRandomString();
    }

    public function get()
    {
        echo "get";
    }

}