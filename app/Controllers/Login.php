<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController {

    public function index(){

        //echo '<pre>'.var_export($estado[0]->estado, true).'</pre>';exit;

        $data['title']='Magic Service';
        $data['main_content']='home/login';
        return view('includes/template_login', $data);  
    }

}
