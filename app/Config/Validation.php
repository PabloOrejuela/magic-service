<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig {

    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $login = [
        'user'  => 'required',
        'password'   => 'required',
    ];

    public $login_errors = [
        'user' => [
            'required' => 'El campo "Usuario" es obligatorio',
        ],
        'password' => [
            'required' => 'El campo "Contraseña" es obligatorio',
        ]
    ];

    public $pedido = [
        'idcliente'  => 'greater_than[0]',
        'nombre'   => 'required',
        'vendedor'  => 'greater_than[0]',
        'producto'  => 'greater_than[0]',
        'formas_pago'  => 'greater_than[0]',
        'sectores'  => 'required',
        //'email'  => 'valid_email',
        'fecha' => 'valid_date'
    ]; 

    public $pedido_errors = [
        'idcliente' => [
            'greater_than[0]' => 'El campo "Cliente" es obligatorio',
        ],
        'nombre' => [
            'required' => 'El campo "Cliente" es obligatorio',
        ],
        'vendedor' => [
            'greater_than' => 'El campo "Vendedor" es obligatorio',
        ],
        'producto' => [
            'greater_than' => 'El campo "Producto" es obligatorio',
        ],
        'formas_pago' => [
            'greater_than' => 'El campo "Forma de pago" es obligatorio',
        ],
        'email' => [
            'valid_email' => 'El "Email" debe ser un email válido',
        ],
        'sectores' => [
            'required' => '',
        ],
    ];

    public $pedidoInicial = [
        'idcliente'  => 'greater_than[0]',
        'nombre'   => 'required',
    ]; 

    public $pedidoInicial_errors = [
        'idcliente' => [
            'greater_than[0]' => 'El campo "Cliente" es obligatorio',
        ],
        'nombre' => [
            'required' => 'El campo "Cliente" es obligatorio',
        ]
    ];

    public $usuario = [
        'nombre'   => 'required',
        'user'   => 'required',
        'password'   => 'required',
        'idroles'   => 'greater_than[0]',
    ]; 

    public $usuario_errors = [
        'idroles' => [
            'greater_than' => 'El campo "Rol" es obligatorio',
        ],
        'nombre' => [
            'required' => 'El campo "Nombre" es obligatorio',
        ],
        'user' => [
            'required' => 'El campo "Usuario" es obligatorio',
        ],
        'password' => [
            'required' => 'El campo "Password" es obligatorio',
        ],
    ];

    public $items = [
        'item'   => 'required',
        'precio'   => 'required|decimal',
    ]; 

    public $items_errors = [
        'item' => [
            'required' => 'El campo "Rol" es obligatorio',
        ],
        'precio' => [
            'required' => 'El campo "Precio" es obligatorio',
            'decimal' => 'El campo "Precio" debe ser una cantidad decimal',
        ],
    ];
}
