<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\UsuarioModel;
use App\Models\FormaPagoModel;
use App\Models\ClienteModel;
use App\Models\ProductoModel;
use App\Models\ItemModel;
use App\Models\PedidoModel;
use App\Models\RolModel;
use App\Models\CategoriaModel;
use App\Models\ItemsProductoModel;
use App\Models\SectoresEntregaModel;
use App\Models\ConfiguracionModel;
use App\Models\HorariosEntregaModel;
use App\Models\DetallePedidoModel;
use App\Models\SucursalModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller {

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url', 'html'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {

        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->db = \Config\Database::connect();
        $this->usuarioModel = new UsuarioModel($this->db);
        $this->clienteModel = new ClienteModel($this->db);
        $this->formaPagoModel = new FormaPagoModel($this->db);
        $this->productoModel = new ProductoModel($this->db);
        $this->itemModel = new ItemModel($this->db);
        $this->pedidoModel = new PedidoModel($this->db);
        $this->rolModel = new RolModel($this->db);
        $this->categoriaModel = new CategoriaModel($this->db);
        $this->itemsProductoModel = new ItemsProductoModel($this->db);
        $this->sectoresEntregaModel = new SectoresEntregaModel($this->db);
        $this->configuracionModel = new ConfiguracionModel($this->db);
        $this->horariosEntregaModel = new HorariosEntregaModel($this->db);
        $this->detallePedidoModel = new DetallePedidoModel($this->db);
        $this->sucursalModel = new SucursalModel($this->db);

        // E.g.: $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->image = \Config\Services::image();
    }
}
