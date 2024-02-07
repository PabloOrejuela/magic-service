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

    function _getPedidos(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(
                $this->table.'.id as id,
                cod_pedido,
                '.$this->table.'.estado as estado,hora,
                clientes.nombre as nombre, 
                fecha_entrega,
                horario_entrega,
                observaciones,
                hora_salida_pedido,
                formas_pago,
                banco,
                fecha,
                sectores_entrega.sector as sector,
                dir_entrega,
                estados_pedidos.estado as estado,
                hora_salida_pedido,ubicacion,
                usuarios.nombre as mensajero'
        );
        $builder->join('clientes', $this->table.'.idcliente = clientes.id');
        $builder->Join('sectores_entrega', $this->table.'.sector = sectores_entrega.id', 'left');
        $builder->join('horarios_entrega', $this->table.'.horario_entrega = horarios_entrega.id', 'left');
        $builder->join('usuarios', $this->table.'.mensajero = usuarios.id', 'left');
        $builder->join('estados_pedidos', $this->table.'.estado = estados_pedidos.id', 'left');
        //$builder->orderBy('id', 'ASC');
        //PABLO revisar que si es admin soplo traiga 300 ultimos y si es otro rol máximo 1000
        $builder->limit(300);
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
        $builder->select(
                $this->table.'.id as id,'.$this->table.'.cod_pedido as cod_pedido,
                '.$this->table.'.estado as estado, 
                nombre,
                documento,
                clientes.id as idcliente,
                procedencia,
                direccion,
                telefono,
                telefono_2,
                email,
                fecha_entrega,
                horario_entrega,
                venta_extra,
                hora,
                fecha,
                hora_salida_pedido,
                vendedor,
                formas_pago,
                banco,
                ubicacion,
                observaciones,
                pedidos.sector as idsector,
                sectores_entrega.sector as sector,
                dir_entrega,
                mensajero,
                valor_mensajero,
                valor_mensajero_edit,
                transporte,
                cargo_horario,
                domingo,
                valor_neto,
                descuento,
                total'
        );
        $builder->join('clientes', $this->table.'.idcliente = clientes.id');
        $builder->join('sectores_entrega', $this->table.'.sector = sectores_entrega.id');
        $builder->join('horarios_entrega', $this->table.'.horario_entrega = horarios_entrega.id');
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

        $builder->insert();
        return  $this->db->insertID();
    }


    public function _update($data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;

        //Actualizo el nuevo pedido
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

        if ($data['formas_pago'] != 'NULL' && $data['formas_pago'] != '') {
            $builder->set('formas_pago', $data['formas_pago']); 
        }

        if ($data['banco'] != 'NULL' && $data['banco'] != '') {
            $builder->set('banco', $data['banco']); 
        }

        if ($data['observaciones'] != 'NULL') {
            $builder->set('observaciones', $data['observaciones']); 
        }

        if ($data['valor_mensajero'] != 'NULL' && $data['valor_mensajero'] != '') {
            $builder->set('valor_mensajero', $data['valor_mensajero']); 
        }

        if ($data['valor_mensajero_edit'] != 'NULL' && $data['valor_mensajero_edit'] != '') {
            $builder->set('valor_mensajero_edit', $data['valor_mensajero_edit']); 
        }

        $builder->where($this->table.'.id', $data['id']);
        $builder->update();
    }

    public function _actualizaMensajero($mensajero, $codigo_pedido) {
        //echo $mensajero;
        $builder = $this->db->table($this->table);

        if ($mensajero != 0 && $mensajero != null) {
            $builder->set('mensajero', $mensajero);
        }


        $builder->where($this->table.'.cod_pedido', $codigo_pedido);
        $builder->update();
    }

    public function _actualizaHorarioEntrega($horario_entrega, $codigo_pedido) {

        $builder = $this->db->table($this->table);

        if ($horario_entrega != 0 && $horario_entrega != null) {
            $builder->set('horario_entrega', $horario_entrega);
        }


        $builder->where($this->table.'.cod_pedido', $codigo_pedido);
        $builder->update();
    }

    public function _actualizarEstadoPedido($estado_pedido, $cod_pedido) {

        $builder = $this->db->table($this->table);

        if ($estado_pedido != 0 && $estado_pedido != null) {
            $builder->set('estado', $estado_pedido);
        }


        $builder->where($this->table.'.cod_pedido', $cod_pedido);
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

    public function _actualizaObservacionPedido($observacionPedido, $cod_pedido) {

        $builder = $this->db->table($this->table);

        $builder->set('observaciones', $observacionPedido);
        $builder->where($this->table.'.cod_pedido', $cod_pedido);
        $builder->update();
    }

    function _verificaCampos($id, $detalle){
        //fecha_entrega, nombre, sector, dir_entrega, cod arreglo, horario_entrega
        $numCampos = 6;
        $result = NULL;
        $builder = $this->db->table($this->table);
        $pedido = $this->_getDatosPedido($id);
        if ($pedido->fecha_entrega != NULL) {
            $numCampos--;
        }

        if ($pedido->nombre != NULL) {
            $numCampos--;
        }

        if ($pedido->sector > 0) {
            $numCampos--;
        }

        if ($pedido->dir_entrega != NULL && $pedido->dir_entrega != '') {
            $numCampos--;
        }

        if ($pedido->horario_entrega != NULL) {
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
