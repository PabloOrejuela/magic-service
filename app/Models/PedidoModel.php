<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'pedidos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function _makeCodproduct($producto){
        $cod = NULL;
        date_default_timezone_set('America/Guayaquil');
        $date = date('ymdHis');

        $cod = $producto['idcliente'].$producto['vendedor'].$producto['producto'].'-'.$date;

        return $cod;
    }

    function _getPedidos($idroles){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,'.$this->table.'.estado as estado,hora,clientes.nombre as nombre, 
                fecha_entrega,horario_entrega,rango_entrega_desde,rango_entrega_hasta,observaciones,hora_salida_pedido,
                formas_pago,banco,fecha,orden,idnegocio,mensajero_extra,valor_devuelto,observacion_devolucion,
                sin_remitente,sectores_entrega.sector as sector,dir_entrega,
                estados_pedidos.estado as estado,
                hora_salida_pedido,ubicacion,
                usuarios.nombre as mensajero,
                observacion_pago'
        );
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->Join('sectores_entrega', $this->table.'.sector = sectores_entrega.id', 'left');
        $builder->join('horarios_entrega', $this->table.'.horario_entrega = horarios_entrega.id', 'left');
        $builder->join('usuarios', $this->table.'.mensajero = usuarios.id', 'left');
        $builder->join('estados_pedidos', $this->table.'.estado = estados_pedidos.id', 'left');
        
        //Si es vendedor solo salen los pedidos en proceso, no los completados y entregados
        if ($idroles > 3) {
            $builder->where('pedidos.estado <=', 3);
            $builder->limit(250);
        }else{
            $builder->limit(350);
        }

        $builder->orderBy('orden', 'asc');
        
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosRangoFechasProcedencias($fechaInicio, $fechaFinal, $negocio){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,nombre as cliente,total,procedencia,negocio');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('pedidos_procedencia', $this->table.'.id = pedidos_procedencia.idpedidos','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->join('procedencias','pedidos_procedencia.idprocedencia= procedencias.id','left');
        $builder->where($this->table.'.estado', 1);

        //Si se ha seleccionado un negocio
        if ($negocio != 0) {
            $builder->where($this->table.'.idnegocio', $negocio);
        }
        
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('fecha', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosRangoFechasNegocio($fechaInicio, $fechaFinal, $negocio){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,nombre as cliente,total,negocio');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->where($this->table.'.estado', 1);

        //Si se ha seleccionado un negocio
        if ($negocio != 0) {
            $builder->where($this->table.'.idnegocio', $negocio);
        }
        
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('fecha', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosRangoFechasVendedor($objeto){

        $fechaInicio = $objeto['fecha_inicio'];
        $fechaFinal = $objeto['fecha_final'];
        $negocio = $objeto['negocio'];
        $vendedor = $objeto['vendedor'];

        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,nombre as cliente,total,negocio,vendedor,venta_extra');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->where($this->table.'.estado', 1);

        //Si se ha seleccionado un negocio
        if ($negocio != 0) {
            $builder->where($this->table.'.idnegocio', $negocio);
        }

        $builder->where($this->table.'.vendedor', $vendedor);
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('orden', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosRangoFechasMensajero($objeto){

        $fechaInicio = $objeto['fecha_inicio'];
        $fechaFinal = $objeto['fecha_final'];
        $negocio = $objeto['negocio'];
        $mensajero = $objeto['mensajero'];

        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,dir_entrega,nombre as cliente,transporte,negocio,mensajero,rango_entrega_desde,rango_entrega_hasta,
                valor_mensajero,valor_mensajero_edit,valor_mensajero_extra,mensajero_extra,venta_extra,sectores_entrega.sector as sector');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->join('sectores_entrega', $this->table.'.sector = sectores_entrega.id','left');
        $builder->where($this->table.'.estado', 1);

        //Si se ha seleccionado un negocio
        if ($negocio != 0) {
            $builder->where($this->table.'.idnegocio', $negocio);
        }

        $builder->where($this->table.'.mensajero', $mensajero);
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('orden', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        // echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosRangoFechasMensajeroExtra($objeto){

        $fechaInicio = $objeto['fecha_inicio'];
        $fechaFinal = $objeto['fecha_final'];
        $negocio = $objeto['negocio'];
        $mensajero = $objeto['mensajero'];

        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,dir_entrega,nombre as cliente,transporte,negocio,mensajero,rango_entrega_desde,rango_entrega_hasta,
                valor_mensajero,valor_mensajero_edit,valor_mensajero_extra,mensajero_extra,venta_extra,sectores_entrega.sector as sector');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->join('sectores_entrega', $this->table.'.sector = sectores_entrega.id','left');
        $builder->where($this->table.'.estado', 1);

        //Si se ha seleccionado un negocio
        if ($negocio != 0) {
            $builder->where($this->table.'.idnegocio', $negocio);
        }

        $builder->where($this->table.'.mensajero_extra', $mensajero);
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('orden', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        // echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosRangoFechasReportes($fechaInicio, $fechaFinal){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,nombre as cliente,total,procedencia,negocio,banco,vendedor,venta_extra,observaciones,pedidos.estado as estado');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('pedidos_procedencia', $this->table.'.id = pedidos_procedencia.idpedidos','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->join('procedencias','pedidos_procedencia.idprocedencia= procedencias.id','left');
        $builder->where($this->table.'.estado', 1);
        $builder->where( "fecha_entrega BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('orden', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidoMasterIngresosMesReportes($negocio, $mes){

        $fechaInicio = $mes.'-01';
        $fechaFinal = $mes.'-31';
        $result = NULL;

        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,nombre as cliente,total,negocio,banco,vendedor,venta_extra,observaciones,pedidos.estado as estado');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->where($this->table.'.estado', 1);
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->where($this->table.'.idnegocio', $negocio);
        $builder->orderBy('orden', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosMesEstadisticas($negocio, $fechaInicio, $fechaFinal, $cant, $orden){

        $result = NULL;

        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,nombre as cliente,total,negocio,banco,vendedor,venta_extra,observaciones,pedidos.estado as estado,pedidos.idcliente as idcliente');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->where($this->table.'.estado', 1);
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        
        if ($negocio != null) {
            $builder->where($this->table.'.idnegocio', $negocio);
        }
        
        $builder->orderBy('orden', $orden);
        
        if ($cant != 0) {
            $builder->limit($cant);
        }
        
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosReporteDiario($fechaInicio, $fechaFinal, $negocio){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha_entrega,fecha,nombre as cliente,total,observacion_pago,
                        procedencia,negocio,banco,vendedor,venta_extra,observaciones,pedidos.estado as estado,pagado,idnegocio,forma_pago');
        
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('formas_pago', $this->table.'.formas_pago = formas_pago.id','left');
        $builder->join('pedidos_procedencia', $this->table.'.id = pedidos_procedencia.idpedidos', 'left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');
        $builder->join('procedencias','pedidos_procedencia.idprocedencia= procedencias.id','left');

        //Si se ha seleccionado un negocio
        if ($negocio != 0) {
            $builder->where($this->table.'.idnegocio', $negocio);
        }

        $builder->where($this->table.'.estado', 1);
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('orden', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getSumatoriaPedidosDia($fecha, $negocio){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('fecha,sum(total) as suma,pedidos.estado as estado,idnegocio');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->where($this->table.'.idnegocio', $negocio);
        $builder->where($this->table.'.estado', 1);
        $builder->where('fecha', $fecha);
        //$builder->groupBy('idnegocio');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row->suma; 
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPedidosRangoFechas($fechaInicio, $fechaFinal){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('id,cod_pedido,fecha_entrega');
        $builder->where('estado', 1);
        $builder->where( "fecha_entrega BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('orden', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getHistorialPedidos($idcliente){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id');
        $builder->Join('sectores_entrega', $this->table.'.sector = sectores_entrega.id', 'left');
        $builder->join('horarios_entrega', $this->table.'.horario_entrega = horarios_entrega.id', 'left');
        $builder->join('usuarios', $this->table.'.mensajero = usuarios.id', 'left');
        $builder->join('estados_pedidos', $this->table.'.estado = estados_pedidos.id', 'left');
        $builder->join('sucursales',  'sectores_entrega.idsucursal = sucursales.id', 'left');
        $builder->where($this->table.'.idcliente', $idcliente);
        //$builder->orderBy('id', 'ASC');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getDatosPedido($idpedido){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,'.$this->table.'.cod_pedido as cod_pedido,'.$this->table.'.estado as estado,idnegocio,observacion_pago,
                nombre,documento,clientes.id as idcliente,direccion,telefono,telefono_2,email,fecha_entrega,sin_remitente,valor_devuelto,
                horario_entrega,venta_extra,hora,fecha,hora_salida_pedido,vendedor,formas_pago,banco,ubicacion,observaciones,observacion_devolucion,
                pedidos.sector as idsector,sectores_entrega.sector as sector,dir_entrega,mensajero,mensajero_extra,valor_mensajero,valor_mensajero_extra,ref_pago,
                valor_mensajero_edit,transporte,cargo_horario,domingo,valor_neto,descuento,total,rango_entrega_desde,rango_entrega_hasta');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('sectores_entrega', $this->table.'.sector = sectores_entrega.id','left');
        $builder->join('horarios_entrega', $this->table.'.horario_entrega = horarios_entrega.id','left');
        $builder->where($this->table.'.id', $idpedido);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getDatosPedidoTicket($idpedido){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,'.$this->table.'.cod_pedido as cod_pedido,
                nombre as cliente,direccion,telefono,telefono_2,fecha_entrega,rango_entrega_desde,rango_entrega_hasta,
                hora,fecha,observaciones,pedidos.sector as idsector,sectores_entrega.sector as sector,dir_entrega,sin_remitente');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('sectores_entrega', $this->table.'.sector = sectores_entrega.id','left');
        $builder->join('horarios_entrega', $this->table.'.horario_entrega = horarios_entrega.id','left');
        $builder->where($this->table.'.id', $idpedido);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _insert($data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        $created_at = date('Y-m-d H:i:s');

        //Inserto el nuevo producto
        $builder = $this->db->table($this->table);
        if ($data['cod_pedido'] != 'NULL' && $data['cod_pedido'] != '') {
            $builder->set('cod_pedido', $data['cod_pedido']);
        }

        if ($data['idcliente'] != 'NULL' && $data['idcliente'] != '') {
            $builder->set('idcliente', $data['idcliente']);
        }

        if ($data['fecha'] != 'NULL' && $data['fecha'] != '') {
            $builder->set('fecha', $data['fecha']);
        }

        if ($data['vendedor'] != 'NULL' && $data['vendedor'] != '') {
            $builder->set('vendedor', $data['vendedor']);
        }

        if ($data['valor_neto'] != 'NULL' && $data['valor_neto'] != '') {
            $builder->set('valor_neto', $data['valor_neto']);
        }

        if ($data['descuento'] != 'NULL' && $data['descuento'] != '') {
            $builder->set('descuento', $data['descuento']);
        }

        if ($data['transporte'] != 'NULL' && $data['transporte'] != '') {
            $builder->set('transporte', $data['transporte']);
        }

        if ($data['sector'] != 'NULL' && $data['sector'] != '') {
            $builder->set('sector', $data['sector']); 
        }

        if ($data['total'] != 'NULL' && $data['total'] != '') {
            $builder->set('total', $data['total']);
        }

        if ($data['venta_extra'] != 'NULL' && $data['venta_extra'] != '') {
            $builder->set('venta_extra', $data['venta_extra']);
        }

        if ($data['fecha_entrega'] != 'NULL' && $data['fecha_entrega'] != '') {
            $builder->set('fecha_entrega', $data['fecha_entrega']);
        }
        
        if ($data['horario_entrega'] != 'NULL' && $data['horario_entrega'] != '') {
            $builder->set('horario_entrega', $data['horario_entrega']); 
        }

        if ($data['rango_entrega_desde'] != 'NULL' && $data['rango_entrega_desde'] != '') {
            $builder->set('rango_entrega_desde', $data['rango_entrega_desde']); 
        }

        if ($data['rango_entrega_hasta'] != 'NULL' && $data['rango_entrega_hasta'] != '') {
            $builder->set('rango_entrega_hasta', $data['rango_entrega_hasta']); 
        }

        if ($data['horario_extra'] != 'NULL' && $data['horario_extra'] != '') {
            $builder->set('cargo_horario', $data['horario_extra']); 
        }

        if ($data['cargo_domingo'] != 'NULL' && $data['cargo_domingo'] != '') {
            $builder->set('domingo', $data['cargo_domingo']); 
        }

        if ($data['valor_mensajero'] != 'NULL' && $data['valor_mensajero'] != '') {
            $builder->set('valor_mensajero', $data['valor_mensajero']); 
        }

        if ($data['valor_mensajero_edit'] != 'NULL' && $data['valor_mensajero_edit'] != '') {
            $builder->set('valor_mensajero_edit', $data['valor_mensajero_edit']); 
        }

        $builder->set('orden', 1); 
        $builder->set('idnegocio', $data['idnegocio']); 

        //Inserto las fechas de creación e inicializo la actualización
        $builder->set('created_at', $created_at); 
        $builder->set('updated_at', $created_at); 

        $builder->set('sin_remitente', $data['sin_remitente']); 
        $builder->insert();
        return  $this->db->insertID();
    }


    public function _update($data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        $updated_at = date('Y-m-d H:i:s');

        //Actualizo el pedido
        $builder = $this->db->table($this->table);
        if ($data['cod_pedido'] != 'NULL' && $data['cod_pedido'] != '') {
            $builder->set('cod_pedido', $data['cod_pedido']);
        }

        if ($data['idcliente'] != 'NULL' && $data['idcliente'] != '') {
            $builder->set('idcliente', $data['idcliente']);
        }

        if ($data['vendedor'] != 'NULL' && $data['vendedor'] != '') {
            $builder->set('vendedor', $data['vendedor']);
        }

        if ($data['valor_neto'] != 'NULL' && $data['valor_neto'] != '') {
            $builder->set('valor_neto', $data['valor_neto']);
        }

        if ($data['descuento'] != 'NULL' && $data['descuento'] != '') {
            $builder->set('descuento', $data['descuento']);
        }

        if ($data['transporte'] != 'NULL' && $data['transporte'] != '') {
            $builder->set('transporte', $data['transporte']);
        }

        if ($data['sector'] != 'NULL' && $data['sector'] != '') {
            $builder->set('sector', $data['sector']); 
        }

        if ($data['total'] != 'NULL' && $data['total'] != '') {
            $builder->set('total', $data['total']);
        }

        if ($data['venta_extra'] != 'NULL' && $data['venta_extra'] != '') {
            $builder->set('venta_extra', $data['venta_extra']);
        }

        if ($data['fecha_entrega'] != 'NULL' && $data['fecha_entrega'] != '') {
            $builder->set('fecha_entrega', $data['fecha_entrega']);
        }
        
        if ($data['horario_entrega'] != 'NULL' && $data['horario_entrega'] != '') {
            $builder->set('horario_entrega', $data['horario_entrega']); 
        }

        if ($data['rango_entrega_desde'] != 'NULL' && $data['rango_entrega_desde'] != '') {
            $builder->set('rango_entrega_desde', $data['rango_entrega_desde']); 
        }

        if ($data['rango_entrega_hasta'] != 'NULL' && $data['rango_entrega_hasta'] != '') {
            $builder->set('rango_entrega_hasta', $data['rango_entrega_hasta']); 
        }

        if ($data['horario_extra'] != 'NULL' && $data['horario_extra'] != '') {
            $builder->set('cargo_horario', $data['horario_extra']); 
        }

        if ($data['cargo_domingo'] != 'NULL' && $data['cargo_domingo'] != '') {
            $builder->set('domingo', $data['cargo_domingo']); 
        }

        if ($data['valor_mensajero'] != 'NULL' && $data['valor_mensajero'] != '') {
            $builder->set('valor_mensajero', $data['valor_mensajero']); 
        }

        if ($data['valor_mensajero_edit'] != 'NULL' && $data['valor_mensajero_edit'] != '') {
            $builder->set('valor_mensajero_edit', $data['valor_mensajero_edit']); 
        }

        if ($data['dir_entrega'] != 'NULL' && $data['dir_entrega'] != '') {
            $builder->set('dir_entrega', $data['dir_entrega']); 
        }

        if ($data['ubicacion'] != 'NULL' && $data['ubicacion'] != '') {
            $builder->set('ubicacion', $data['ubicacion']); 
        }

        if ($data['observaciones'] != 'NULL' && $data['observaciones'] != '') {
            $builder->set('observaciones', $data['observaciones']); 
        }

        if ($data['mensajero'] != 'NULL' && $data['mensajero'] != '') {
            $builder->set('mensajero', $data['mensajero']); 
        }

        if ($data['formas_pago'] != 'NULL' && $data['formas_pago'] != '') {
            $builder->set('formas_pago', $data['formas_pago']); 
        }

        if ($data['banco'] != 'NULL' && $data['banco'] != '') {
            $builder->set('banco', $data['banco']); 
        }

        if ($data['ref_pago'] != 'NULL' && $data['ref_pago'] != '') {
            $builder->set('ref_pago', $data['ref_pago']); 
        }

        if ($data['estado'] != 'NULL' && $data['estado'] != '') {
            $builder->set('estado', $data['estado']); 
        }

        if ($data['mensajero_extra'] != 'NULL' && $data['mensajero_extra'] != '' && $data['mensajero_extra'] != '0') {
            $builder->set('mensajero_extra', $data['mensajero_extra']); 
            $builder->set('valor_mensajero_extra', $data['valor_mensajero_extra']); 
        }else{
            $builder->set('mensajero_extra', $data['mensajero_extra']); 
            $builder->set('valor_mensajero_extra', '0.00'); 
        }

        $builder->set('observacion_pago', $data['observacion_pago']); 
        $builder->set('idnegocio', $data['idnegocio']); 
        $builder->set('updated_at', $updated_at); 

        $builder->set('sin_remitente', $data['sin_remitente']); 
        $builder->where($this->table.'.id', $data['idpedido']);
        $builder->update();
    }

    public function _actualizaMensajero($mensajero, $idpedido) {
        //echo $mensajero;
        $builder = $this->db->table($this->table);

        if ($mensajero != 0 && $mensajero != null) {
            $builder->set('mensajero', $mensajero);
        }


        $builder->where($this->table.'.id', $idpedido);
        $builder->update();
    }

    public function _actualizarEstadoPedido($estado_pedido, $idpedido, $orden) {

        $builder = $this->db->table($this->table);

        if ($estado_pedido != 0 && $estado_pedido != null) {

            $builder->set('estado', $estado_pedido);

            if ($estado_pedido >= 4) {
                $builder->set('orden', 299);
            }
        }


        $builder->where($this->table.'.id', $idpedido);
        $builder->update();
    }

    public function _actualizarHoraSalidaPedido($hora_salida_pedido, $cod_pedido) {

        $builder = $this->db->table($this->table);

        if ($hora_salida_pedido != 0 && $hora_salida_pedido != null && $hora_salida_pedido != '') {
            $builder->set('hora_salida_pedido', $hora_salida_pedido);
        }

        $builder->where($this->table.'.cod_pedido', $cod_pedido);
        $builder->update();
    }

    public function _actualizaObservacionPedido($observacionPedido, $idpedido) {

        $builder = $this->db->table($this->table);

        $builder->set('observaciones', $observacionPedido);
        $builder->where($this->table.'.id', $idpedido);
        $builder->update();
    }

    function _getDevolucionesMesReporte($fechaInicio, $fechaFinal, $negocio){
        
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,cod_pedido,fecha,nombre as cliente,negocio,vendedor,total,pedidos.estado as estado,pagado,valor_devuelto,observacion_devolucion,idnegocio');
        $builder->join('clientes', $this->table.'.idcliente = clientes.id','left');
        $builder->join('negocios', $this->table.'.idnegocio = negocios.id','left');

        //Si se ha seleccionado un negocio
        if ($negocio != 0) {
            $builder->where($this->table.'.idnegocio', $negocio);
        }

        $builder->where($this->table.'.estado', 1);
        $builder->where($this->table.'.valor_devuelto >', 0);
        $builder->where( "fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('orden', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    /*
    *   
    */

    function _verificaCampos($id, $detalle){
        //fecha_entrega, nombre, sector, dir_entrega, cod arreglo, horario_entrega
        $numCampos = 6;
        $result = NULL;
        $builder = $this->db->table($this->table);
        $pedido = $this->_getDatosPedido($id);

        //echo '<pre>'.var_export(isset($pedido->fecha_entrega), true).'</pre>';

        if (isset($pedido->fecha_entrega) && $pedido->fecha_entrega != NULL) {
            $numCampos--;
        }

        if (isset($pedido->nombre) && $pedido->nombre != NULL) {
            $numCampos--;
        }

        if (isset($pedido->nombre) && $pedido->sector > 0) {
            $numCampos--;
        }

        if (isset($pedido->dir_entrega) && $pedido->dir_entrega != NULL && $pedido->dir_entrega != '') {
            $numCampos--;
        }

        if (isset($pedido->horario_entrega) && $pedido->horario_entrega != NULL) {
            $numCampos--;
        }
        
        // if ($pedido->hora_salida_pedido != NULL) {
        //     $numCampos--;
        // }

        if (isset($detalle) && count($detalle) > 0) {
            $numCampos--;
        }
        return $numCampos;
        //echo '<pre>'.var_export($detalle, true).'</pre>';
        //echo '<pre>'.var_export($pedido, true).'</pre>';exit;
    }
}
