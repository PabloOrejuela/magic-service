<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController {

    public function index(){

        $data['title']='Magic Service';
        $data['main_content']='login';
        return view('includes/template_login', $data);
    }
}
