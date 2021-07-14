<?php

use App\Http\BaseController;
use App\Models\Link;
use App\Models\Response;

class HomeController extends BaseController
{
    public function index()
    {
        $slug = $_GET['url'];

        // using cache


        //using database
        $url = new Link();
        $url = $url->find('slug', $slug);
        if (count($url)) {
            header("location:" . $url[0]['url']);
        } else {
            Response::not_found();
        }
    }
}