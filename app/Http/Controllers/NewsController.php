<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function subscription(Request $request)
    {
        $user = \Auth::user();
        $endpoint = $request->endpoint;
        $key = $request->key;
        $token = $request->token;
        $user->updatePushSubscription($endpoint, $key, $token);

        return ['result' => true];
    }
}
