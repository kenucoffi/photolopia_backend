<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    //
    function follower_request(string $id){
        $user = Auth::user();
        $user_id = $user->id;
        
    }
}
