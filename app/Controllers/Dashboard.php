<?php

namespace App\Controllers;

class Dashboard extends BaseController {

    public function index(){
        $data['arreglo'] = array(1, 2,3);
        $data['title']='Magic Service';
        $data['main_content']='prueba';
        //return view('includes/template', $data);
        return view('dashboard/index', $data);
    }
}
