<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;


use App\Models\DevelopmentError;
use Illuminate\Support\Facades\Route;

function DevelopmentErrorLog($message, $line)
{
    // echo $message . ' ' . $line;
    $currentURL = URL::current();
    $fullURL = URL::full();
    $getControllerFunction = Route::getCurrentRoute()->getActionName();
    $ip = \request()->ip();
    $userAgent = \request()->server('HTTP_USER_AGENT');
    if (isset(Auth::user()->id)) {
        $User = Auth::user()->id;
    } else {
        $User = 'Gust';
    }

    $errorLog = new DevelopmentError([
        'user_id' =>  $User,
        'current_url' => $currentURL,
        'full_url' => $fullURL,
        'ip' => $ip,
        'function' => $getControllerFunction,
        'user_agent' => $userAgent,
        'message' => ' Error Line: ' . $line . '-> Message ' . $message,
        'status' => 0 // 0 is error not fixed yet
    ]);
    $errorLog->save();

    return 132123;
}
