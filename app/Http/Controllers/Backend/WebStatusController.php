<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebStatusController extends Controller
{
    //
    public function index($user)
    {
        $list = $user->monitors()->get();
        return view('backend.web-status.index', compact('list'));
    }

}
