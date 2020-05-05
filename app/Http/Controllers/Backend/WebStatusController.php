<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class WebStatusController extends Controller
{
    //
    public function index($user)
    {
        $list = $user->monitors()->get();

        return view('backend.web-status.index', compact('list'));
    }
}
