<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController {

    public function index(){

        $this->sessionModel->_signOff($this->session->id);
        // echo '<pre>'.var_export($this->session->id, true).'</pre>';exit;
        
        $data['title']='Magic Service';
        $data['main_content']='home/login';
        return view('includes/template_login', $data);  
    }
}
