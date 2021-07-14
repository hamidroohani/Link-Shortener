<?php

use App\Http\BaseController;
use App\Models\CacheFile;
use App\Models\Link;
use App\Models\Response;

class HomeController extends BaseController
{
    public function index()
    {
        $slug = $_GET['url'];

        // using cache
        $url = CacheFile::remember($slug, function () use ($slug) {
            $url = new Link();
            return $url->find('slug', $slug);
        });

        if (count($url)) {
            header("location:" . $url[0]['url']);
        } else {
            Response::not_found();
        }
    }
}