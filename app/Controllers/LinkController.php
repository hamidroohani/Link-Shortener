<?php

use App\Http\BaseController;
use App\Models\CacheFile;
use App\Models\Link;
use App\Models\Response;

class LinkController extends BaseController
{
    public function index()
    {
        echo generateRandomString();
    }

    public function create()
    {
        $url = $_POST['link'];

        // validate url
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            Response::not_valid_url();
        }

        // using cache
        $result = CacheFile::remember($url, function () use ($url) {
            $record = new Link();
            return $record->find('url', $url);
        });


        if (count($result)) {
            Response::success($result[0]['slug']);
        }

        //create new slug
        $length = 6;
        $new_slug = generateRandomString($length);
        $record = new Link();
        $record = $record->find('slug', $new_slug);

        // check duplicate record
        $try = 0;
        while (count($record)) {
            $new_slug = generateRandomString($length);
            $record = new Link();
            $record = $record->find('slug', $new_slug);
            $try++;

            // if the finding new slug was difficult, guess with larger length
            if ($try > 20) {
                $length++;
                $try = 0;
            }
        }

        $record = new Link();
        $record->insert(['url',
            'slug'], [$url,
            $new_slug]);
        Response::success($new_slug);
    }

}