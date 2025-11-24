<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\SessionModel;

class AuthFilter implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {

        $session = session();

        // Si no hay sesión activa → redirigir
        if (!$session->has('idsession') || !$session->is_logged) {
            return redirect()->to('/');
        }

        $sessionModel = new SessionModel();

        //Sesiones anteriores del mismo usuario
        $sessionAnterior = $sessionModel
                            ->where('idusuario', $session->id)
                            ->where('is_logged', 1)
                            ->findAll();

        //Sesión actual en BD
        $sessionActual = $sessionModel
                          ->where('id', $session->idsession)
                          ->first();
        
        //Cierre de sesiones anteriores
        if ($sessionAnterior) {
            foreach ($sessionAnterior as $ses) {
                if ($ses->id != $session->idsession 
                    && $sessionActual->is_logged == 1 
                    && $sessionActual->status == 1) {

                    $set = [
                        'is_logged' => 0,
                        'status'    => 0,
                    ];

                    $sessionModel->update($ses->id, $set);
                }
            }
        }

        //Si la sesión actual está cerrada en BD → redirigir
        if ($sessionActual->is_logged != 1 || $sessionActual->status != 1) {
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {

        // No se necesita nada aquí por eso no he puesto cógigo
    }
}
