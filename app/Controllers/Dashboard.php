<?php

namespace App\Controllers;

class Dashboard extends BaseController {

    protected $system_version = SYSTEM_VERSION;

    public function index(){
        $data['arreglo'] = array(1, 2,3);
        $data['title']='Magic Service';
        $data['main_content']='prueba';
        $data['version'] = $this->system_version;
        //return view('includes/template', $data);
        return view('dashboard/index', $data);
    }
}
