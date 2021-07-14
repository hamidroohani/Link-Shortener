<?php

use App\Http\BaseController;
use App\Models\CacheFile;
use App\Models\Link;
use App\Models\Response;
use App\Models\Token;

class LinkController extends BaseController
{
    public function check_token()
    {
        $headers = apache_request_headers();
        if (!isset($headers['token'])) Response::require_parameters("token");

        $token = new Token();
        $token = $token->where("token", "=", $headers['token'])->where("expire_date", ">", date("Y-m-d H:i:s"))->get();
        if (!count($token)) Response::not_valid_token();
    }

    public function index()
    {
        $this->check_token();
        $record = new Link();
        Response::all_links($record->all());
    }

    public function create()
    {
        if (!isset($_POST['link'])) {
            Response::param_not_found();
        }

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

    public function destroy()
    {
        $this->check_token();
        $id = $_POST['id'];
        if (!isset($_POST['id'])) Response::require_parameters("id");
        $record = new Link();
        $record->delete($id);
        Response::delete_successfully();
    }
}