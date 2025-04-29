<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
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
        'fecha_entrega'   => 'required|min_length[8]',
        'nombre'   => 'required',
        'telefono'   => 'required|min_length[9]',
        'vendedor'   => 'required|greater_than[0]',
        'sectores'   => 'required|greater_than[0]',
        
    ]; 

    public $pedidoInicial_errors = [
        'fecha_entrega' => [
            'required' => 'El campo "Fecha de entrega" es obligatorio',
        ],
        'nombre' => [
            'required' => 'El campo "Cliente" es obligatorio',
        ],
        'vendedor' => [
            'greater_than' => 'El campo "Vendedor" es obligatorio',
        ],
        'sectores' => [
            'greater_than' => 'El campo "Sector en Transporte" es obligatorio',
        ],
        'telefono' => [
            'required' => 'El campo "Teléfono" es obligatorio',
            'min_length' => 'El campo "Teléfono" es obligatorio',
        ]
    ];

    public $pedidoUpdate = [
        'fecha_entrega'   => 'required|min_length[8]',
        'nombre'   => 'required',
        'telefono'   => 'required|min_length[9]',
        'vendedor'   => 'required|greater_than[0]',
        'sectores'   => 'required|greater_than[0]',
        
    ]; 

    public $pedidoUpdate_errors = [
        'fecha_entrega' => [
            'required' => 'El campo "Fecha de entrega" es obligatorio',
        ],
        'nombre' => [
            'required' => 'El campo "Cliente" es obligatorio',
        ],
        'vendedor' => [
            'greater_than' => 'El campo "Vendedor" es obligatorio',
        ],
        'sectores' => [
            'greater_than' => 'El campo "Sector en Transporte" es obligatorio',
        ],
        'telefono' => [
            'required' => 'El campo "Teléfono" es obligatorio',
            'min_length' => 'El campo "Teléfono" es obligatorio',
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

    public $usuarioUpdate = [
        'nombre'   => 'required',
        'user'   => 'required',
        'idroles'   => 'greater_than[0]',
    ]; 

    public $usuarioUpdate_errors = [
        'idroles' => [
            'greater_than' => 'El campo "Rol" es obligatorio',
        ],
        'nombre' => [
            'required' => 'El campo "Nombre" es obligatorio',
        ],
        'user' => [
            'required' => 'El campo "Usuario" es obligatorio',
        ]
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

    public $formas_pago = [
        'forma_pago'   => 'required',
    ]; 

    public $formas_pago_errors = [
        'forma_pago' => [
            'required' => 'El campo "Forma de pago" es obligatorio',
        ]
    ];

    public $inst_financiera = [
        'banco'   => 'required',
    ]; 

    public $inst_financiera_errors = [
        'banco' => [
            'required' => 'El campo "Institución Financiera" es obligatorio',
        ]
    ];

    public $cliente = [
        'nombre'   => 'required',
    ]; 

    public $cliente_errors = [
        'nombre' => [
            'required' => 'El campo "Nombre" es obligatorio',
        ],
    ];

    public $sucursal = [
        'sucursal'   => 'required',
        'direccion'   => 'required',
    ]; 

    public $sucursal_errors = [
        'sucursal' => [
            'required' => 'El campo "Sucursal" es obligatorio',
        ],
        'direccion' => [
            'required' => 'El campo "Dirección" es obligatorio',
        ],
    ];

    public $proveedor = [
        'nombre'   => 'required',
        'contacto'   => 'required',
    ]; 

    public $proveedor_errors = [
        'nombre' => [
            'required' => 'El campo "Nombre" es obligatorio',
        ],
        'contacto' => [
            'required' => 'El campo "Nombre Contacto" es obligatorio',
        ],
    ];

    public $gasto = [
        'sucursal'   => 'greater_than[0]',
        'negocio'   => 'greater_than[0]',
        'proveedor'   => 'greater_than[0]',
        'tipo'   => 'greater_than[0]',
        'documento'   => 'required',
        'valor'   => 'required',
    ]; 

    public $gasto_errors = [
        'sucursal' => [
            'greater_than' => 'El campo "Sucursal" es obligatorio',
        ],
        'negocio' => [
            'greater_than' => 'El campo "Negocio" es obligatorio',
        ],
        'proveedor' => [
            'greater_than' => 'El campo "Proveedor" es obligatorio',
        ],
        'tipo' => [
            'greater_than' => 'El campo "Tipo" es obligatorio',
        ],
        'documento' => [
            'required' => 'El campo "Documento / Factura" es obligatorio',
        ],
        'valor' => [
            'required' => 'El campo "Valor pagado" es obligatorio',
        ],
    ];

    public $gestionInventario = [
        'id'   => 'required',
        'item'   => 'required',
        'movimiento'   => 'greater_than[0]',
        'unidades'   => 'required|greater_than[0]',
        'stock_actual'   => 'required',
        'precio'   => 'required|greater_than[0]',
    ];
    public $gestionInventario_errors = [
        'id' => [
            'required' => 'El campo "Item" es obligatorio',
        ],
        'item' => [
            'required' => 'El campo "Item" es obligatorio',
        ],
        'movimiento' => [
            'greater_than' => 'El campo "Tipo de Movimiento" es obligatorio',
        ],
        'unidades' => [
            'required' => 'El campo "Unidades" es obligatorio',
            'greater_than' => 'El campo "Unidades" debe ser mayor que 0',
        ],
        'precio' => [
            'required' => 'El campo "Precio" es obligatorio',
            'greater_than' => 'El campo "Precio" debe ser mayor que 0',
        ],
    ];

    public $product = [
        'idusuario'   => 'required',
        'nombreArregloNuevo'   => 'required',
        'categoria'   => 'required|greater_than[0]',
        'new_id'   => 'required|greater_than[0]',
    ]; 

    public $product_errors = [
        'nombreArregloNuevo' => [
            'required' => 'El campo "Nombre del nuevo arreglo" es obligatorio',
        ],
        'categoria' => [
            'required' => 'El campo "Categoría" es obligatorio',
            'greater_than' => 'El campo "Categoría" es obligatorio',
        ],
        'new_id' => [
            'required' => 'El campo "ID" es obligatorio',
        ],
    ];

    public $reporteEstadisticasVendedor = [
        'vendedor'  => 'required|greater_than[0]',
    ];

    public $reporteEstadisticasVendedor_errors = [
        'vendedor' => [
            'required' => 'El campo "Vendedor" es obligatorio',
            'greater_than' => 'El campo "Vendedor" es obligatorio',
        ],
    ];

    public $reporteMasterIngresos = [
        'negocio'  => 'required|greater_than[0]',
    ];

    public $reporteMasterIngresos_errors = [
        'negocio' => [
            'required' => 'El campo "Negocio" es obligatorio',
            'greater_than' => 'El campo "Negocio" es obligatorio',
        ],
    ];
}
