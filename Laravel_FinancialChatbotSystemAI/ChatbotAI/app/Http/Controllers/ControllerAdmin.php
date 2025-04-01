<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerAdmin extends Controller
{
    //
    public function admin(){
        return view('chatbotai.manager.admin');
    }
}
