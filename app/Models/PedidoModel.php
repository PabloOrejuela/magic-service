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
                direccion,
                telefono,
                email,
                fecha_entrega,
                horario_entrega,
                hora,
                fecha,
                vendedor,
                ubicacion,
                observaciones,
                sectores_entrega.sector as sector,
                dir_entrega,
                mensajero'
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
        
        if (isset($detalle) && count($detalle) > 0) {
            $numCampos--;
        }
        return $numCampos;
        // echo '<pre>'.var_export($numCampos, true).'</pre>';
        // echo '<pre>'.var_export($pedido, true).'</pre>';exit;
    }
}
