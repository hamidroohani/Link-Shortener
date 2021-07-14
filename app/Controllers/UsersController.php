<?php

use App\Http\BaseController;
use App\Models\Response;
use App\Models\Token;
use App\Models\User;

class UsersController extends BaseController
{
    public function login()
    {
        if (!isset($_POST['email']) || !isset($_POST['password']))
        {
            Response::require_parameter("email and password");
        }
        $username = $_POST['email'];
        $password = md5($_POST['password']);

        $user = new User();
        $user = $user->select('users')->where('email',"=",$username)->where("password","=",$password)->get();
        if (count($user)){
            $token = generateRandomString(30);
            $token_user = new Token();
            $token_user->insert(['user_id','token','created_at','expire_date'],[$user[0]['id'],$token,date("Y-m-d H:i:s"),date("Y-m-d H:i:s",strtotime('tomorrow'))],$user[0]['id']);
            Response::success_token($token);
        }
    }
}